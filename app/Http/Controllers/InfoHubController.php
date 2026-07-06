<?php

namespace App\Http\Controllers;

use App\Models\InfoHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoHubController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'nullable|string|max:255',
            'poster_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'poster_link'  => 'nullable|url|max:255',
        ]);

        $path = $request->file('poster_image')->store('posters', 'public');

        InfoHub::create([
            'title'        => $request->title,
            'poster_image' => $path,
            'poster_link'  => $request->poster_link,
            'is_active'    => true,
        ]);

        return back()->with('success', 'Poster berhasil diupload.');
    }

    public function update(Request $request, InfoHub $infoHub)
    {
        $request->validate([
            'title'        => 'nullable|string|max:255',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'poster_link'  => 'nullable|url|max:255',
            'is_active'    => 'boolean',
        ]);

        $data = $request->only('title', 'poster_link', 'is_active');

        if ($request->hasFile('poster_image')) {
            // Delete old image
            if ($infoHub->poster_image) {
                Storage::disk('public')->delete($infoHub->poster_image);
            }
            $data['poster_image'] = $request->file('poster_image')->store('posters', 'public');
        }

        $infoHub->update($data);

        return back()->with('success', 'Poster berhasil diperbarui.');
    }

    public function destroy(InfoHub $infoHub)
    {
        if ($infoHub->poster_image) {
            Storage::disk('public')->delete($infoHub->poster_image);
        }
        $infoHub->delete();

        return back()->with('success', 'Poster berhasil dihapus.');
    }

    public function toggleActive(InfoHub $infoHub)
    {
        $infoHub->update(['is_active' => !$infoHub->is_active]);

        return back()->with('success', 'Status poster diperbarui.');
    }
}
