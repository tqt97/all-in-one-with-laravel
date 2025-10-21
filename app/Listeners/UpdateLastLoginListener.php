<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class UpdateLastLoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private Request $request)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $event->user->forceFill([
            'last_login_ip' => $this->request->ip(),
            'last_login_at' => now(),
        ])->saveQuietly();
    }
}
