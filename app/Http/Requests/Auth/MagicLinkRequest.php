<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class MagicLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match (true) {
            $this->routeIs('magic.send') => $this->sendRules(),
            $this->routeIs('magic.verify') => $this->verifyRules(),
            default => [],
        };
    }

    protected function sendRules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }

    protected function verifyRules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'hash' => ['required', 'string'],
            'expires' => ['required', 'integer'],
            'signature' => ['required', 'string'],
        ];
    }
}
