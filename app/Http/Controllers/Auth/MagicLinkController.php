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

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => explode('@', $email)[0]]
        );

        $url = URL::temporarySignedRoute(
            'magic.verify',
            now()->addMinutes(30),
            [
                'email' => $user->email,
                'hash' => sha1($user->email),
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
            abort(401, 'Link expired or invalid');
        }

        $user = User::whereEmail($request->validated()['email'])->firstOrFail();

        if (! hash_equals(sha1($user->email), $request->validated()['hash'])) {
            abort(403, 'Invalid signature hash');
        }

        Auth::login($user);

        if (is_null($user->email_verified_at)) {
            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();
        }

        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }
}
