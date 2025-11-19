<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPostRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogDetailController extends Controller
{
    public function index($id)
    {
        $title = "جزئیات خبر";

        $post = Post::with(['category', 'admin.file', 'legacyAdmin', 'file', 'comments.user'])
            ->where('status', 1)
            ->where('id', $id)
            ->firstOrFail();

        // Increment views count
        $post->increment('views');

        // Get comments for this post
        $comments = Comment::with('user')
            ->where('post_id', $post->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {

                if ($comment->created_at && !($comment->created_at instanceof Carbon)) {
                    $comment->created_at = Carbon::parse($comment->created_at);
                }
                return $comment;
            });

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->favoritePosts()->where('post_id', $post->id)->exists();
        }

        return view('blog.blogDetail', compact('title', 'post', 'comments', 'isFavorite'));
    }

    public function storeComment(CommentPostRequest $request)
    {
        $validated = $request->validated();

        $commentData = [
            'post_id' => $validated['post_id'],
            'content' => $validated['content'],
        ];

        // If user is logged in, use their user_id
        if (Auth::check()) {
            $commentData['user_id'] = Auth::id();
        } else {
            // For guests, store name and email
            $commentData['guest_name'] = $validated['guest_name'];
            $commentData['guest_email'] = $validated['guest_email'];
            $commentData['user_id'] = null;
        }

        Comment::create($commentData);

        return back()->with('success', 'دیدگاه شما با موفقیت ثبت شد.');
    }
}
