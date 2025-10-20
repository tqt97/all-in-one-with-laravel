<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SocialiteProviderRequest extends FormRequest
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
        return [
            'provider' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (! in_array($value, config('services.socialite_providers'))) {
                        $fail('Invalid provider.');
                    }
                },
            ],
        ];
    }

    /**
     * Merge the provider from the route into the request.
     *
     * This method is necessary because route model binding does not work
     * with the Socialite package.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'provider' => $this->route('provider'),
        ]);
    }
}
