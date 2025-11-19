<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ProfileUpdateRequest;
use App\Http\Requests\Account\PasswordUpdateRequest;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "داشبورد";
        $user = Auth::user();

        // Favorites with custom page name
        $favorites = $user->favoritePosts()
            ->with(['file', 'category'])
            ->orderByPivot('created_at', 'desc')
            ->paginate(4, ['*'], 'favorites_page');

        // Recent comments with custom page name
        $recentComments = $user->comments()
            ->with(['post.file'])
            ->latest()
            ->paginate(4, ['*'], 'comments_page');

        return view('account.dashboard', compact('title', 'user', 'favorites', 'recentComments'));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $file = FileUploadService::uploadImage(
                $request->file('avatar'),
                'avatars',
                300,
                300
            );
            $data['avatar_file_id'] = $file?->id;
        }

        if ($request->boolean('remove_avatar')) {
            $data['avatar_file_id'] = null;
        }

        $user->update(collect($data)->except(['avatar', 'remove_avatar'])->toArray());

        return back()->with('success_profile', 'اطلاعات حساب کاربری با موفقیت به‌روزرسانی شد.');
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return back()->with('success_password', 'رمز عبور با موفقیت تغییر کرد.');
    }
}
