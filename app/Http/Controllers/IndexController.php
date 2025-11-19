<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $title = "صفحه اصلی";


        $posts = Post::with([ 'category', 'admin.file', 'legacyAdmin', 'file'])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $favoritePostIds = [];
        if (Auth::check()) {
            $favoritePostIds = Auth::user()->favoritePosts()->pluck('posts.id')->toArray();
        }

        return view('index', compact('title', 'posts', 'favoritePostIds'));
    }
}

