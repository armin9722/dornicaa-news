<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();

        $exists = $user->favoritePosts()->where('post_id', $post->id)->exists();

        if ($exists) {
            $user->favoritePosts()->detach($post->id);
            return back()->with('success_favorite', 'خبر از لیست علاقه‌مندی‌ها حذف شد.');
        }

        $user->favoritePosts()->attach($post->id);
        return back()->with('success_favorite', 'خبر به لیست علاقه‌مندی‌ها اضافه شد.');
    }
}



