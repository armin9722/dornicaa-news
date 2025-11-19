<?php

namespace App\Http\Requests\Admin\Auth;

use App\Enums\Gender;
use App\Enums\MilitaryServiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AdminEditRequest extends FormRequest
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
        $userId = $this->route('admin') ?? $this->route('id') ?? $this->input('id');

        return [
            "first_name" => [
                "sometimes",
                "nullable",
                "string",
                "max:100",
                "persian_alpha"
            ],
            "last_name" => [
                "sometimes",
                "nullable",
                "string",
                "max:100",
            ],
            "mobile" => [
                "sometimes",
                "nullable",
                Rule::unique('users', 'mobile')->ignore($userId),
                "string",
                "size:11",
                "ir_mobile:zero",
            ],
            "email" => [
                "sometimes",
                "nullable",
                "email",
                Rule::unique('users', 'email')->ignore($userId),
                "max:100",
            ],
            "username" => [
                "sometimes",
                "nullable",
                "string",
                "max:255",
                Rule::unique('users', 'username')->ignore($userId),
                "regex:/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z0-9_]+$/u",
            ],
            "password" => [
                "sometimes",
                "nullable",
                "string",
                "min:6",
                "confirmed",
            ],
        ];
    }



    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.persian_alpha' => 'نام باید شامل حروف فارسی باشد.',
            'last_name.persian_alpha' => 'نام خانوادگی باید شامل حروف فارسی باشد.',
            'mobile.ir_mobile' => 'شماره موبایل معتبر نیست.',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',
            'username.unique' => 'این نام کاربری قبلاً ثبت شده است.',
            'username.regex' => 'نام کاربری باید شامل حروف انگلیسی و اعداد باشد.',
            'password.confirmed' => 'تأیید رمز عبور مطابقت ندارد.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Remove password fields if not provided
        if (!$this->filled('password')) {
            $this->request->remove('password');
            $this->request->remove('password_confirmation');
        }
    }
}
