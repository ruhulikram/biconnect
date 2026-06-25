<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     * If no user is provided, show the authenticated user's profile.
     */
    public function show(?User $user = null): View
    {
        $user = $user ?? auth()->user();

        $user->loadCount(['posts', 'followers', 'following']);
        $user->load(['skills', 'socialLinks']);
        $posts = $user->posts()
            ->latest()
            ->with(['user', 'skills', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->paginate(10);

        $isOwner = $user->id === auth()->id();
        $isFollowing = false;

        if (! $isOwner) {
            $isFollowing = auth()->user()->following()->where('following_id', $user->id)->exists();
        }

        return view('profile.show', compact('user', 'posts', 'isOwner', 'isFollowing'));
    }

    /**
     * Show the profile edit form.
     */
    public function edit(): View
    {
        $user = auth()->user();
        $user->load(['skills', 'socialLinks']);

        $allSkills = Skill::orderBy('name')->get();
        $selectedSkillIds = $user->skills->pluck('id')->toArray();

        // Build a map of existing social links by platform
        $socialLinks = $user->socialLinks->pluck('url', 'platform')->toArray();

        return view('profile.edit', compact('user', 'allSkills', 'selectedSkillIds', 'socialLinks'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->only(['name', 'bio', 'program', 'semester', 'campus_area']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($user->cover) {
                Storage::disk('public')->delete($user->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $user->update($data);

        // Sync skills
        if ($request->has('skills')) {
            $user->skills()->sync($request->input('skills', []));
        } else {
            $user->skills()->detach();
        }

        // Sync social links (upsert pattern)
        $platforms = array_keys(\App\Models\SocialLink::platforms());
        foreach ($platforms as $platform) {
            $url = $request->input("social_{$platform}");
            if (!empty($url)) {
                $user->socialLinks()->updateOrCreate(
                    ['platform' => $platform],
                    ['url' => $url]
                );
            } else {
                $user->socialLinks()->where('platform', $platform)->delete();
            }
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Follow a user.
     */
    public function follow(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat mengikuti diri sendiri.');
        }

        auth()->user()->following()->syncWithoutDetaching([$user->id]);

        return back()->with('success', 'Berhasil mengikuti ' . $user->name . '.');
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $user): RedirectResponse
    {
        auth()->user()->following()->detach($user->id);

        return back()->with('success', 'Berhenti mengikuti ' . $user->name . '.');
    }
}
