<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use PragmaRX\Google2FALaravel\Listeners\LoginViaRemember;

class LoginViaRememberListener extends LoginViaRemember
{
    /**
     * Xử lý event "login via remember".
     */
    public function handle(Login $event): void
    {
        parent::handle($event);
    }
}
