<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostInterest;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('feed.index');
        }

        $stats = Cache::remember('landing_stats', 300, function () {
            return [
                'users' => User::where('is_active', true)->where('onboarding_completed', true)->count(),
                'projects' => Post::where('type', 'project')->where('status', 'approved')->count(),
                'interests' => PostInterest::count(),
            ];
        });

        return view('landing', compact('stats'));
    }
}
