<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if ($this->isMethod('patch')) {
            $this->errorBag = 'reviewUpdate';
        }
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => 'Text recenzie je povinný.',
            'text.max' => 'Recenzia môže mať najviac 2000 znakov.',
        ];
    }
}
