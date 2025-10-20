<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuthenticator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If 2fa is not enabled or session var is false
        if (! Auth::user()->two_factor_secret || $request->session()->get(config('google2fa.session_var'), false)) {
            return $next($request);
        }

        return to_route('two-factor.verify.form.otp');
    }
}
