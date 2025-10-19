<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TwoFactor\OtpRequest;
use App\Services\Auth\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    private const SESSION_2FA_SECRET = '2fa_secret';

    private const SESSION_2FA_CODES = '2fa_recovery_codes';

    public function __construct(protected readonly TwoFactorService $twoFactorService) {}

    /**
     * Enable 2FA for the current user.
     */
    public function enable(OtpRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $otp = $request->validated('otp');
        $secret = session(self::SESSION_2FA_SECRET);
        $recoveryCodes = session(self::SESSION_2FA_CODES, []);

        if ($this->twoFactorService->enable($user, $otp, $secret, $recoveryCodes)) {
            session()->forget([self::SESSION_2FA_SECRET, self::SESSION_2FA_CODES]);
            Auth::logout();

            return redirect()->route('login')->with('status', __('2fa.enable_success'));
        }

        return back()->withErrors(['otp' => __('2fa.enable_fail')]);
    }

    /**
     * Disable 2FA for the current user.
     */
    public function disable(OtpRequest $request): RedirectResponse
    {
        if ($this->twoFactorService->disable(Auth::user(), $request->validated('otp'))) {
            session([config('google2fa.session_var') => false]);

            return back()->with('status', __('2fa.disable_success'));
        }

        return back()->withErrors(['otp' => __('2fa.verify_invalid')]);
    }
}
