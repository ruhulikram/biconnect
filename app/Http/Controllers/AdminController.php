<?php

namespace App\Http\Controllers;

use App\Models\InfoHub;
use App\Models\Post;
use App\Models\PostInterest;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard index with overview metrics,
     * recent reports, and recent users.
     */
    public function index(): View
    {
        $stats = [
            'total_users'      => User::count(),
            'active_posts'     => Post::active()->count(),
            'pending_reports'  => Report::pending()->count(),
            'collaborations'   => PostInterest::count(),
        ];

        $recentReports = Report::with(['reporter', 'reportable'])
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::latest()
            ->take(10)
            ->get();

        $posters = InfoHub::latest()->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'recentUsers', 'posters'));
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

    /**
     * Display a paginated list of reports with status filter.
     */
    public function reports(Request $request): View
    {
        $status = $request->query('status');

        $reports = Report::with(['reporter', 'reportable'])
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reports', compact('reports', 'status'));
    }

    /**
     * Handle the status update of a report (handled/rejected).
     */
    public function handleReport(Report $report, Request $request): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:handled,rejected',
        ]);

        $status = $request->input('status');
        $report->status = $status;
        $report->save();

        // If the report was handled and it reported a post, optionally deactivate the post
        if ($status === 'handled' && $report->reportable_type === Post::class) {
            $post = $report->reportable;
            if ($post) {
                $post->is_active = false;
                $post->save();
            }
        }

        // If the report was handled and it reported a user, optionally deactivate the user
        if ($status === 'handled' && $report->reportable_type === User::class) {
            $user = $report->reportable;
            if ($user && $user->id !== auth()->id()) {
                $user->is_active = false;
                $user->save();
            }
        }

        return redirect()->back()->with('success', 'Laporan berhasil diproses.');
    }
}
