<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(): View
    {
        return view('settings.index');
    }

    /**
     * Toggle dark mode for the authenticated user.
     */
    public function updateDarkMode(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'dark_mode' => 'required|boolean',
        ]);

        auth()->user()->update([
            'dark_mode' => $request->boolean('dark_mode'),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Pengaturan tampilan diperbarui.');
    }
}
