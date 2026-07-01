<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search posts and users.
     * Returns JSON for the modal dropdown.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (mb_strlen(trim($query)) < 2) {
            return response()->json([
                'users' => [],
                'posts' => [],
            ]);
        }

        $users = User::where('is_active', true)
            ->where('onboarding_completed', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('program', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(fn($user) => [
                'id'         => $user->id,
                'name'       => $user->name,
                'avatar_url' => $user->avatar_url,
                'program'    => $user->program,
                'url'        => route('profile.show.user', $user),
            ]);

        $posts = Post::with('user')
            ->where('is_active', true)
            ->where('status', 'approved')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('body', 'like', "%{$query}%");
            })
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'id'    => $post->id,
                'title' => $post->title ?: \Illuminate\Support\Str::limit($post->body, 60),
                'type'  => $post->type,
                'url'   => route('post.show', $post),
            ]);

        return response()->json([
            'users' => $users,
            'posts' => $posts,
        ]);
    }
}
