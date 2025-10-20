<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorService
{
    public function __construct(protected readonly Google2FA $google2fa) {}

    /**
     * Enable 2FA for the authenticated user.
     */
    public function enable(User $user, string $otp, ?string $secret, array $recoveryCodes): bool
    {
        if (blank($secret) || ! $this->verifyOtp($otp, $secret)) {
            return false;
        }

        $user->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => json_encode($this->getHashedRecoveryCodes($recoveryCodes)),
            'two_factor_confirmed_at' => now(),
        ])->save();

        return true;
    }

    /**
     * Disable 2FA for the authenticated user.
     */
    public function disable(User $user, string $otp): bool
    {
        if (! $this->verifyOtp($otp, $user->two_factor_secret)) {
            return false;
        }

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return true;
    }

    /**
     * Verify an OTP against a user's 2FA secret.
     */
    public function verifyLoginOtp(User $user, string $otp): bool
    {
        return $this->verifyOtp($otp, $user->two_factor_secret);
    }

    /**
     * Verify an OTP against a secret key.
     */
    private function verifyOtp(string $otp, ?string $secret): bool
    {
        return filled($secret) && $this->google2fa->verifyKey($secret, $otp);
    }

    /**
     * Verify and consume a recovery code
     */
    public function verifyRecoveryCodes(User $user, string $otp): bool
    {
        $recoveryCodes = json_decode($user->two_factor_recovery_codes, true) ?? [];

        foreach ($recoveryCodes as $i => $hashed) {
            if (Hash::check($otp, $hashed)) {
                unset($recoveryCodes[$i]);
                $user->forceFill([
                    'two_factor_recovery_codes' => json_encode(array_values($recoveryCodes)),
                ])->save();

                return true;
            }
        }

        return false;
    }

    /**
     * Hash recovery codes stored in session.
     */
    private function getHashedRecoveryCodes(array $recoveryCodes): array
    {
        return collect($recoveryCodes)
            ->map(fn ($code) => Hash::make($code))
            ->values()
            ->all();
    }
}
