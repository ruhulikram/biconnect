<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    /**
     * Toggle like/unlike on a post.
     */
    public function toggle(Post $post): JsonResponse
    {
        $user = auth()->user();

        if ($user->likedPosts()->where('post_id', $post->id)->exists()) {
            $user->likedPosts()->detach($post->id);
            $liked = false;
        } else {
            $user->likedPosts()->attach($post->id);
            $liked = true;
        }

        $count = $post->likes()->count();

        return response()->json([
            'liked' => $liked,
            'count' => $count,
        ]);
    }
}
