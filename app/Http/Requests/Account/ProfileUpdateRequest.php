<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id ?? null;

        return [
            'first_name' => ['required', 'string', 'max:100', 'persian_alpha'],
            'last_name' => ['required', 'string', 'max:100', 'persian_alpha'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId),
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z0-9_]+$/u',
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:800',
            ],
            'remove_avatar' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'نام کاربری باید ترکیبی از حروف انگلیسی و اعداد باشد.',
        ];
    }
}



