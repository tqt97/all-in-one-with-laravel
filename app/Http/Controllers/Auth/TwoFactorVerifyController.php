<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TwoFactor\OtpRequest;
use App\Http\Requests\Auth\TwoFactor\RecoveryCodeRequest;
use App\Services\Auth\TwoFactorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TwoFactorVerifyController extends Controller
{
    public function __construct(
        protected readonly TwoFactorService $twoFactorService
    ) {}

    /**
     * Show the two factor authentication page
     */
    public function showOtpForm(): View
    {
        return view('auth.two-factor-verify-otp');
    }

    public function showRecoveryForm(): View
    {
        return view('auth.two-factor-verify-recovery');
    }

    /**
     * Verify the two factor authentication code
     */
    public function verifyOtp(OtpRequest $request): RedirectResponse
    {
        if ($this->twoFactorService->verifyLoginOtp(Auth::user(), $request->validated('otp'))) {
            session([config('google2fa.session_var') => true]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['otp' => __('2fa.verify_invalid')]);
    }

    /**
     * Verify the two factor authentication recovery code
     */
    public function verifyRecovery(RecoveryCodeRequest $request): RedirectResponse
    {
        if ($this->twoFactorService->verifyRecoveryCodes(Auth::user(), $request->validated('code'))) {
            session([config('google2fa.session_var') => true]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['otp' => __('2fa.verify_recovery_invalid')]);
    }
}
