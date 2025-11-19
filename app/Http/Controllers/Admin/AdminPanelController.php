<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Auth\AdminEditUserRequest;

class AdminPanelController extends Controller
{
    /**
     * Show the admin panel with paginated users.
     */
    public function index(Request $request)
    {
        $title = 'پنل مدیریت کاربران';

        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.panel', compact('title', 'users'));
    }

        /**
     * Show the edit user form.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }
    /**
     * Update user profile.
     */
    public function update(AdminEditUserRequest $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'mobile'     => 'nullable|string|max:20',
            'password'   => 'nullable|string|min:6|confirmed',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->mobile     = $request->mobile;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.panel')->with('success', 'کاربر با موفقیت بروزرسانی شد.');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.panel')->with('success', 'کاربر حذف شد.');
    }

    /**
     * Toggle admin status.
     */
    public function toggleAdmin(User $user)
    {
        $user->is_admin = !$user->is_admin;
        $user->save();

        $message = $user->is_admin ? 'کاربر به مدیر تبدیل شد.' : 'کاربر از مدیران حذف شد.';
        return redirect()->route('admin.panel')->with('success', $message);
    }


}
