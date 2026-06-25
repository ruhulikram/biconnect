<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Show the report creation form.
     */
    public function create(Request $request): View
    {
        $request->validate([
            'type' => 'required|in:post,user',
            'id'   => 'required|integer',
        ]);

        $type = $request->query('type');
        $id = $request->query('id');

        // Determine the reportable entity name for display
        $targetName = '';
        if ($type === 'post') {
            $post = Post::findOrFail($id);
            $targetName = $post->title ?? 'Postingan #' . $post->id;
        } else {
            $user = User::findOrFail($id);
            $targetName = $user->name;
        }

        return view('report.create', compact('type', 'id', 'targetName'));
    }

    /**
     * Store a new report.
     */
    public function store(StoreReportRequest $request): RedirectResponse
    {
        $type = $request->input('reportable_type');
        $id = $request->input('reportable_id');

        // Map short type to full model class
        $reportableType = $type === 'post' ? Post::class : User::class;

        // Check if target exists
        if ($type === 'post') {
            Post::findOrFail($id);
        } else {
            User::findOrFail($id);
        }

        // Prevent duplicate reports
        $existing = Report::where('reporter_id', auth()->id())
            ->where('reportable_type', $reportableType)
            ->where('reportable_id', $id)
            ->where('status', 'pending')
            ->exists();

        if ($existing) {
            return back()->with('error', 'Kamu sudah melaporkan ini sebelumnya.');
        }

        Report::create([
            'reporter_id'     => auth()->id(),
            'reportable_type' => $reportableType,
            'reportable_id'   => $id,
            'reason'          => $request->input('reason'),
            'detail'          => $request->input('detail'),
        ]);

        // Redirect back to the appropriate page
        if ($type === 'post') {
            return redirect()->route('post.show', $id)->with('success', 'Laporan terkirim. Terima kasih telah membantu menjaga komunitas.');
        }

        return redirect()->route('profile.show.user', $id)->with('success', 'Laporan terkirim. Terima kasih telah membantu menjaga komunitas.');
    }
}
