<?php

namespace App\Http\Controllers;

use App\Models\InfoHub;
use App\Models\Post;
use App\Models\PostInterest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard index with overview metrics and recent users.
     */
    public function index(): View
    {
        $stats = [
            'total_users'      => User::count(),
            'active_posts'     => Post::where('status', 'approved')->count(),
            'pending_projects' => Post::where('type', 'project')->where('status', 'pending')->count(),
            'collaborations'   => PostInterest::count(),
        ];

        $recentUsers = User::latest()
            ->take(10)
            ->get();

        $posters = InfoHub::latest()->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'posters'));
    }

    /**
     * Display pending project approvals.
     */
    public function pendingProjects(Request $request): View
    {
        $projects = Post::with(['user', 'skills'])
            ->where('type', 'project')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.projects', compact('projects'));
    }

    /**
     * Approve a pending project.
     */
    public function approveProject(Post $post): RedirectResponse
    {
        abort_if($post->type !== 'project', 404);

        $post->update(['status' => 'approved', 'is_active' => true]);

        // Send notification to the user who posted the project
        if ($post->user) {
            $post->user->notify(new \App\Notifications\ProjectApproved($post));
        }

        return back()->with('success', 'Project "' . $post->title . '" berhasil disetujui dan dipublikasikan.');
    }

    /**
     * Reject a pending project.
     */
    public function rejectProject(Request $request, Post $post): RedirectResponse
    {
        abort_if($post->type !== 'project', 404);

        $reason = $request->input('reason');

        $post->update(['status' => 'rejected', 'is_active' => false]);

        // Send notification to the post owner with the rejection reason
        if ($post->user) {
            $post->user->notify(new \App\Notifications\ProjectRejected($post, $reason ?: null));
        }

        return back()->with('success', 'Project "' . $post->title . '" ditolak.');
    }

    /**
     * Display a paginated list of users with search functionality.
     */
    public function users(Request $request): View
    {
        $search = $request->query('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users', compact('users', 'search'));
    }

    /**
     * Display the Info Kampus (Info Hub) management page.
     */
    public function infoKampus(): View
    {
        $posters = InfoHub::latest()->get();

        return view('admin.info-kampus', compact('posters'));
    }

    /**
     * Display all posts with status filter.
     */
    public function allPosts(Request $request): View
    {
        $status = $request->query('status', 'all');

        $query = Post::with(['user', 'skills'])
            ->withCount(['comments', 'likes', 'interests'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $posts = $query->paginate(15)->withQueryString();

        $counts = [
            'all'      => Post::count(),
            'approved' => Post::where('status', 'approved')->count(),
            'pending'  => Post::where('status', 'pending')->count(),
            'closed'   => Post::where('status', 'closed')->count(),
            'rejected' => Post::where('status', 'rejected')->count(),
        ];

        return view('admin.posts', compact('posts', 'counts'));
    }

    /**
     * Toggle the active status of a user.
     */
    public function toggleUserStatus(User $user): JsonResponse
    {
        // Don't allow deactivating oneself
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak bisa menonaktifkan akun sendiri.'
            ], 400);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success'   => true,
            'is_active' => $user->is_active,
            'message'   => 'Status pengguna berhasil diperbarui.'
        ]);
    }

}
