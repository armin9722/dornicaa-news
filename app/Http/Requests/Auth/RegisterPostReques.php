<?php

namespace App\Http\Requests\Auth;

use App\Enums\Gender;
use App\Enums\MilitaryServiceStatus;
use Illuminate\Foundation\Http\FormRequest;

class RegisterPostReques extends FormRequest
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
            // Personal Information
            "first_name" => [
                "required",
                "string",
                "max:100",
                "persian_alpha"
            ],
            "last_name" => [
                "required",
                "string",
                "max:100",
            ],
            "national_code" => [
                "required",
                "digits:10",
                "size:10",
                "unique:users,national_code",
                "ir_national_id"
            ],
            "gender" => [
                "required",
                "integer",
                "in:" . implode(',', Gender::values()),
            ],
            "mobile" => [
                "required",
                "string",
                "size:11",
                "ir_mobile:zero",
                "unique:users,mobile",
            ],


            "email" => [
                "required",
                "email",
                "unique:users,email",
                "max:100",
            ],
            "username" => [
                "required",
                "string",
                "max:255",
                "unique:users,username",
                "regex:/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z0-9_]+$/u",
            ],
            "password" => [
                "required",

                "min:6",

                "confirmed",
            ],


            "province_id" => [
                "nullable",
                "integer",
                "exists:provinces,id",
            ],
            "city_id" => [
                "nullable",
                "integer",
                "exists:cities,id",
            ],


            "military_service_status" => [
                "required",
                "integer",
                "in:" . implode(',', MilitaryServiceStatus::values()),
            ],


            "image" => [
                "nullable",
                "image",
                "mimes:jpeg,jpg,png,gif",
                "max:800", // 800KB in kilobytes

            ],

            "security_code" => [
                "required",
                "string",
                function ($attribute, $value, $fail) {
                    $expected = session('register_security_code');
                    if (!$expected) {
                        $fail('کد امنیتی منقضی شده است. لطفا صفحه را مجددا بارگذاری کنید.');
                        return;
                    }

                    if ($value !== $expected) {
                        $fail('کد امنیتی وارد شده صحیح نیست.');
                    }
                }
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
            'mobile.required' => 'شماره همراه الزامی است',
            'mobile.string' => 'شماره همراه باید رشته باشد',
            'mobile.size' => 'شماره همراه باید 11 رقم باشد',
            'mobile.ir_mobile' => 'شماره همراه معتبر نیست. لطفا شماره را با فرمت 09xxxxxxxxx وارد کنید',
            'mobile.ir_mobile:zero' => 'شماره همراه معتبر نیست. لطفا شماره را با فرمت 09xxxxxxxxx وارد کنید',
            'mobile.unique' => 'این شماره همراه قبلا ثبت شده است',
            'username.regex' => 'نام کاربری باید ترکیبی از حروف انگلیسی و اعداد باشد.',
            'security_code.required' => 'وارد کردن کد امنیتی الزامی است.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('security_code')) {
            $this->merge([
                'security_code' => to_english_digits((string) $this->input('security_code')),
            ]);
        }
    }
}
