<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterPostReques;
use App\Models\User;
use App\Models\Role;
use App\Services\FileUploadService;
use App\Services\WelcomeEmailService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisterController
{
    public function index()
    {
        $title = "ثبت نام";
        return view('auth.register', [
            'title' => $title,
            'rawLayout' => true,
            'securityCode' => $this->generateSecurityCode(),
        ]);
    }

    public function post(RegisterPostReques $request)
    {
        try {
            $input = $request->validated();

            // Hash the password
            $input['password'] = Hash::make($input['password']);

            // Set military service status for females
            if ($request->gender == 1) {
                $input['military_service_status'] = 0; // None for females
            } else {
                $input['military_service_status'] = $request->military_service_status ?? 0;
            }

            // Set default status
            $input['status'] = 1;

            // Assign default role (regular user)
            $defaultRoleId = Role::query()
                ->where('name', 'user')
                ->value('id')
                ?? Role::query()->min('id');

            if (!$defaultRoleId) {
                throw new Exception('نقش پیش‌فرض کاربر پیدا نشد');
            }
            $input['role_id'] = $defaultRoleId;

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $fileRecord = FileUploadService::uploadImage($request->file('image'), 'avatars', 50, 50);
                $input['avatar_file_id'] = $fileRecord->id;
            }

            $user = User::create($input);

            Auth::login($user);

            try {
                app(WelcomeEmailService::class)->send($user);
            } catch (Exception $mailException) {
                Log::error('Welcome email error: '.$mailException->getMessage());
            }

            session()->forget('register_security_code');

            $fullName = full_name($user->first_name, $user->last_name);
            return redirect()->route('index')->with('success', 'خوش آمدید ' . $fullName . '! ثبت نام شما با موفقیت انجام شد.');

        } catch (ValidationException $e) {
            // Validation errors are automatically handled by FormRequest
            throw $e;
        } catch (Exception $exception) {
            Log::error('Registration error: ' . $exception->getMessage());
            Log::error($exception);
            return back()->withErrors([
                "general" => "خطایی در پشتیبانی رخ داده است"
            ])->withInput();
        }
    }

    private function generateSecurityCode(): string
    {
        $length = random_int(6, 8);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= (string) random_int(0, 9);
        }

        session(['register_security_code' => $code]);

        return to_persian_digits($code);
    }
}
