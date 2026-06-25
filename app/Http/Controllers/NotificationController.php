<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user.
     */
    public function index(): View
    {
        $user = auth()->user();

        $notifications = $user->notifications()->latest()->paginate(10);
        $unreadNotifications = $user->unreadNotifications;

        return view('notifications.index', compact('notifications', 'unreadNotifications'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
