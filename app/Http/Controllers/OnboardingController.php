<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    /**
     * Tampilkan Step 1: Lengkapi Profil
     */
    public function stepProfile()
    {
        // Jika sudah onboarding, jangan biarkan kembali ke sini
        if (auth()->user()->onboarding_completed) {
            return redirect()->route('feed.index');
        }

        return view('onboarding.profile', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Simpan data profil dari Step 1, lalu lanjut Step 2
     */
    public function saveProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'campus_area' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'program' => $request->program,
            'campus_area' => $request->campus_area,
        ]);

        return redirect()->route('onboarding.skills');
    }

    /**
     * Tampilkan Step 2: Pilih Keahlian
     */
    public function stepSkills()
    {
        if (auth()->user()->onboarding_completed) {
            return redirect()->route('feed.index');
        }

        return view('onboarding.skills', [
            'allSkills' => Skill::all(),
            'selectedSkills' => auth()->user()->skills->pluck('id')->toArray()
        ]);
    }

    /**
     * Simpan keahlian dari Step 2, tandai onboarding_completed = true, lanjut Feed
     */
    public function saveSkills(Request $request)
    {
        $request->validate([
            'skills' => 'required|array|min:3',
            'skills.*' => 'exists:skills,id',
        ], [
            'skills.min' => 'Pilih minimal 3 keahlian.'
        ]);

        $user = auth()->user();
        $user->skills()->sync($request->skills);
        $user->update(['onboarding_completed' => true]);

        return redirect()->route('feed.index')->with('success', 'Profil berhasil dilengkapi! Selamat datang di BiConnect.');
    }

    /**
     * Lewati onboarding, tandai onboarding_completed = true, lanjut Feed
     */
    public function skip()
    {
        $user = auth()->user();
        $user->update(['onboarding_completed' => true]);

        return redirect()->route('feed.index')->with('success', 'Selamat datang di BiConnect!');
    }
}
