<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'min:8', Password::defaults()],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Meno je povinné.',
            'current_password.required_with' => 'Pre zmenu hesla zadaj staré heslo.',
            'current_password.current_password' => 'Staré heslo nie je správne.',
            'password.min' => 'Nové heslo musí mať aspoň 8 znakov.',
        ];
    }
}
