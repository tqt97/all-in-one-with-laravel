<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TwoFactorRequest;
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
    public function show(): View
    {
        return view('auth.two-factor-verify');
    }

    /**
     * Verify the two factor authentication code
     */
    public function verify(TwoFactorRequest $request): RedirectResponse
    {
        if ($this->twoFactorService->verifyLoginOtp(Auth::user(), $request->validated('otp'))) {
            session([config('google2fa.session_var') => true]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['otp' => __('2fa.verify_invalid')]);
    }
}
