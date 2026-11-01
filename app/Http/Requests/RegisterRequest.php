<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'birth_date' => ['required', 'date', 'before_or_equal:'.now()->subYears(18)->toDateString()],
            'password' => ['required', 'confirmed', 'min:8', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'birth_date.before_or_equal' => 'Musíš mať aspoň 18 rokov.',
            'birth_date.required' => 'Dátum narodenia je povinný.',
            'birth_date.date' => 'Zadaj platný dátum.',
        ];
    }
}
