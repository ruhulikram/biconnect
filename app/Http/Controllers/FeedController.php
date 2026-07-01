<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Post;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    /**
     * Display the feed list.
     */
    public function index(Request $request): View
    {
        $query = Post::query()
            ->with(['user', 'skills'])
            ->withCount(['comments', 'likes', 'interests'])
            ->where('status', 'approved')
            ->active();

        // 1. Filter by Post Type (from route tab or filter sheet)
        if ($request->filled('type') && in_array($request->type, ['discussion', 'project'])) {
            $query->where('type', $request->type);
        }

        // 2. Filter by Campus Area
        if ($request->filled('campus_area')) {
            $query->where('campus_area', $request->campus_area);
        }

        // 3. Filter by Project Type (Category)
        if ($request->filled('project_type')) {
            $query->where('project_type', $request->project_type);
        }

        // 4. Filter by Skills
        if ($request->filled('skills')) {
            $skillIds = is_array($request->skills) ? $request->skills : explode(',', $request->skills);
            $query->whereHas('skills', function ($q) use ($skillIds) {
                $q->whereIn('skills.id', $skillIds);
            });
        }

        // 5. Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'popular') {
            $query->orderByDesc('likes_count')->orderByDesc('comments_count')->orderByDesc('id');
        } else {
            $query->latest();
        }

        // Paginate results (10 items per page) and keep query params
        $posts = $query->paginate(10)->withQueryString();

        // Fetch all skills for the filter sheet
        $allSkills = Skill::orderBy('name')->get();

        // Fetch campus areas from database
        $campusAreas = Campus::pluck('name', 'code')->toArray();

        return view('feed.index', compact('posts', 'allSkills', 'campusAreas'));
    }
}
