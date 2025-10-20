<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // If user has 2FA enabled
        if ($user->hasTwoFactorEnabled()) {
            return view('profile.edit', [
                'user' => $user,
            ]);
        }

        // If user doesn't have 2FA
        return view('profile.edit', array_merge(
            ['user' => $user],
            $this->generateTwoFactorData($user)
        ));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Generate an array of data needed for the 2FA form.
     */
    protected function generateTwoFactorData(User $user): array
    {
        $google2fa = app('pragmarx.google2fa');
        $recoveryCodes = app('pragmarx.recovery')->toArray();
        $secret = $google2fa->generateSecretKey();
        $QR_Image = $google2fa->getQRCodeInline(config('app.name'), $user->email, $secret);

        session([
            '2fa_secret' => $secret,
            '2fa_recovery_codes' => $recoveryCodes,
        ]);

        return compact('QR_Image', 'secret', 'recoveryCodes');
    }
}
