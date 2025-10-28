<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PreventCommonPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array(strtolower($value), $this->commonPasswords())) {
            $fail('The chosen password is not strong enough. Try again with a more secure string.');
        }
    }

    /**
     * Returns an array of commonly used weak passwords.
     * These are used to validate against in the validate method.
     */
    private function commonPasswords(): array
    {
        return [
            'picture1',
            'password',
            'password1',
            '12345678',
            '111111',
            '123123',
            '12345',
            '1234567890',
            'senha',
            '1234567',
            'qwerty',
            'abc123',
            'Million2',
            'OOOOOO',
            '1234',
            'iloveyou',
            'aaron431',
            'qqww1122',
            '123',
            'omgpop',
            '123321',
            '654321',
            '123456789',
            'qwerty123',
            '1q2w3e4r',
            'admin',
            'qwertyuiop',
            '555555',
            'lovely',
            '7777777',
            'welcome',
            '888888',
            'princess',
            'dragon',
            '123qwe',
            'sunshine',
            '666666',
            'football',
            'monkey',
            '!@#$%^&*',
            'charlie',
            'aa123456',
            'donald',
        ];
    }
}
