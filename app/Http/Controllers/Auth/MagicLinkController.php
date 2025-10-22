<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MagicLinkRequest;
use App\Models\User;
use App\Notifications\Auth\MagicLinkNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class MagicLinkController extends Controller
{
    const EXPIRATION_MINUTES = 10;

    /**
     * Show the magic link signin form.
     */
    public function showForm(): View
    {
        return view('auth.magic');
    }

    /**
     * Handle an incoming magic link signin request.
     */
    public function sendLink(MagicLinkRequest $request): RedirectResponse
    {
        $email = $request->validated()['email'];

        $user = User::where('email', $email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'No account found with this email address.']);
        }

        $url = URL::temporarySignedRoute(
            'magic.verify',
            now()->addMinutes(self::EXPIRATION_MINUTES),
            [
                'email' => $user->email,
            ]
        );

        $user->notify(new MagicLinkNotification($url));

        return back()->with('status', 'We sent you a magic link! Please check your email.');
    }

    /**
     * Handle an incoming magic link signin request.
     */
    public function verify(MagicLinkRequest $request): RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('magic.form')
                ->withErrors(['magic_link' => 'This magic link has expired. Please request a new one.']);
        }

        $user = User::whereEmail($request->validated()['email'])->firstOrFail();

        Auth::login($user);

        if (is_null($user->email_verified_at)) {
            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();
        }

        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }
}
