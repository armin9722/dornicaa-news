<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentPostRequest extends FormRequest
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
        $rules = [
            'post_id' => 'required|integer|exists:posts,id',
            'content' => 'required|string|min:3|max:1000',
        ];

        // If user is not logged in, require name and email
        if (!auth()->check()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'required|email|max:255';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'content.required' => 'متن دیدگاه الزامی است',
            'content.min' => 'متن دیدگاه باید حداقل 3 کاراکتر باشد',
            'content.max' => 'متن دیدگاه نباید بیشتر از 1000 کاراکتر باشد',
            'guest_name.required' => 'نام الزامی است',
            'guest_email.required' => 'ایمیل الزامی است',
            'guest_email.email' => 'ایمیل معتبر نیست',
        ];
    }
}





