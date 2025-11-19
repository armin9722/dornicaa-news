<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginPostRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController
{
    public function index()
    {
        $title="ورود به حساب کاربری";
        return view('auth.login',[
            'title'=>$title,
            'rawLayout'=>true
        ]);

    }
    public function post(LoginPostRequest $request)
    {
        try {
            $user = User::query()
                ->where('email', $request->input('email'))
                ->first();

            // Check if user exists

            if (!$user) {
                return back()
                    ->withErrors([
                        "general" => 'اطلاعات وارد شده نامعتبر است'
                    ])
                    ->withInput();
            }

            // Check password
            if (!Hash::check($request->input('password'), $user->password)) {
                return back()
                    ->withErrors([
                        "general" => 'اطلاعات وارد شده نامعتبر است'
                    ])
                    ->withInput();
            }

            // Login the user
            Auth::login($user);

            $fullName = full_name($user->first_name, $user->last_name);
            return redirect()->route('index')->with('success', 'خوش آمدید ' . $fullName . '! شما با موفقیت وارد شدید.');

        } catch (Exception $exception) {
            Log::error('Login error: ' . $exception->getMessage());
            Log::error($exception);

            return back()
                ->withErrors([
                    "general" => 'خطایی در ورود رخ داده است'
                ])
                ->withInput();
        }
    }
}
