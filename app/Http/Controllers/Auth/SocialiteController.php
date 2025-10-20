<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SocialiteProviderRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the authorization URL for the given provider.
     *
     * @throws \InvalidArgumentException
     */
    public function redirect(SocialiteProviderRequest $request): mixed
    {

        try {
            return Socialite::driver($request->validated('provider'))->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['provider' => $e->getMessage()]);
        }
    }

    /**
     * Handle the callback from the OAuth provider.
     */
    public function callback(SocialiteProviderRequest $request): RedirectResponse
    {
        $socialUser = Socialite::driver('github')->user();
        if (empty($socialUser)) {
            return redirect()->route('login')->withErrors(['provider' => 'User not found.']);
        }

        $user = User::updateOrCreate([
            'provider_id' => $socialUser->id,
            'provider_name' => $request->validated('provider'),
        ], [
            'name' => $socialUser->name,
            'email' => $socialUser->email,
            'provider_token' => $socialUser->token,
            'provider_refresh_token' => $socialUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
