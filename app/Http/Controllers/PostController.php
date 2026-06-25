<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostInterest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Show the create post form.
     */
    public function create(): View
    {
        $skills = Skill::orderBy('name')->get();

        $campusAreas = [
            'Kramat 98'    => 'Kramat 98 (Pusat)',
            'Margonda'     => 'Margonda (Depok)',
            'Cengkareng'   => 'Cengkareng (Jakarta Barat)',
            'Jatiwaringin' => 'Jatiwaringin (Jakarta Timur)',
            'Kaliabang'    => 'Kaliabang (Bekasi)',
            'Salemba 22'   => 'Salemba 22 (Jakarta Pusat)',
            'Ciledug'      => 'Ciledug (Tangerang)',
            'Fatmawati'    => 'Fatmawati (Jakarta Selatan)',
        ];

        return view('post.create', compact('skills', 'campusAreas'));
    }

    /**
     * Store a new post.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Create the post
        $post = Post::create([
            'user_id'      => auth()->id(),
            'type'         => $validated['type'],
            'title'        => $validated['title'] ?? null,
            'body'         => $validated['body'],
            'image'        => $imagePath,
            'deadline'     => $validated['deadline'] ?? null,
            'campus_area'  => $validated['campus_area'] ?? null,
            'project_type' => $validated['project_type'] ?? null,
            'is_active'    => true,
        ]);

        // Sync skills
        if (!empty($validated['skills'])) {
            $post->skills()->sync($validated['skills']);
        }

        return redirect()
            ->route('feed.index')
            ->with('success', 'Post berhasil dipublikasikan! 🎉');
    }

    /**
     * Show the post detail page.
     */
    public function show(Post $post): View
    {
        $post->load([
            'user',
            'skills',
            'interests.user',
            'comments' => function ($q) {
                $q->topLevel()
                  ->with(['user', 'replies.user'])
                  ->latest();
            },
        ]);

        $post->loadCount(['comments', 'likes', 'interests']);

        $alreadyInterested = false;
        if (auth()->check()) {
            $alreadyInterested = $post->interests()->where('user_id', auth()->id())->exists();
        }

        return view('post.show', compact('post', 'alreadyInterested'));
    }

    /**
     * Delete (deactivate) a post.
     */
    public function destroy(Post $post): RedirectResponse
    {
        // Only post owner can delete
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus post ini.');
        }

        $post->update(['is_active' => false]);

        return redirect()
            ->route('feed.index')
            ->with('success', 'Post berhasil dihapus.');
    }

    /**
     * Store interest in a project post.
     */
    public function storeInterest(Post $post): RedirectResponse
    {
        if ($post->type !== 'project') {
            return back()->with('error', 'Hanya post project yang bisa diminati.');
        }

        // Prevent self-interest
        if ($post->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa tertarik pada post sendiri.');
        }

        // Prevent duplicate interest
        $exists = PostInterest::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah menyatakan ketertarikan pada project ini.');
        }

        PostInterest::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Ketertarikan berhasil dikirim! Pemilik project akan menghubungi Anda. 🤝');
    }

    /**
     * Store a comment on a post.
     */
    public function storeComment(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'body'      => ['required', 'string', 'min:2', 'max:1000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ], [
            'body.required' => 'Komentar tidak boleh kosong.',
            'body.min'      => 'Komentar minimal 2 karakter.',
            'body.max'      => 'Komentar maksimal 1000 karakter.',
        ]);

        Comment::create([
            'post_id'   => $post->id,
            'user_id'   => auth()->id(),
            'parent_id' => $request->parent_id,
            'body'      => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
