<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CounselingSession;

// Handles all Counselor pages and actions
class CounselorController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $counselorId = Auth::id();

        $stats = [
            'upcoming'  => CounselingSession::where('counselor_id', $counselorId)
                            ->where('status', 'pending')
                            ->where('scheduled_at', '>=', now())
                            ->count(),
            'completed' => CounselingSession::where('counselor_id', $counselorId)
                            ->where('status', 'completed')
                            ->count(),
            'ongoing'   => CounselingSession::where('counselor_id', $counselorId)
                            ->where('status', 'ongoing')
                            ->count(),
        ];

        // Get upcoming sessions for today's schedule
        $upcomingSessions = CounselingSession::with('student')
            ->where('counselor_id', $counselorId)
            ->where('status', 'pending')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        return view('counselor.dashboard', compact('stats', 'upcomingSessions'));
    }

    // List all sessions assigned to this counselor
    public function sessions()
    {
        $sessions = CounselingSession::with('student')
            ->where('counselor_id', Auth::id())
            ->latest('scheduled_at')
            ->get();

        return view('counselor.sessions', compact('sessions'));
    }

    // Start a session (change status to 'ongoing')
    public function conductSession(CounselingSession $session)
    {
        // Make sure this counselor owns this session
        if ($session->counselor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $session->update(['status' => 'ongoing']);
        return redirect()->back()->with('success', 'Session started!');
    }

    // Show the "Update Notes" form for a session
    public function editNotes(CounselingSession $session)
    {
        if ($session->counselor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        return view('counselor.edit-notes', compact('session'));
    }

    // Save the updated notes and mark session as completed
    public function updateNotes(Request $request, CounselingSession $session)
    {
        if ($session->counselor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'notes' => 'required|string',
        ]);

        $session->update([
            'notes'  => $request->notes,
            'status' => 'completed',
        ]);

        return redirect('/counselor/sessions')->with('success', 'Notes saved and session marked as completed!');
    }
}
