<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CounselingSession;

// Handles all Student pages and actions
class StudentController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $studentId = Auth::id();

        $stats = [
            'upcoming'  => CounselingSession::where('student_id', $studentId)
                            ->whereIn('status', ['pending', 'ongoing'])
                            ->count(),
            'completed' => CounselingSession::where('student_id', $studentId)
                            ->where('status', 'completed')
                            ->count(),
        ];

        // Get next upcoming session
        $nextSession = CounselingSession::with('counselor')
            ->where('student_id', $studentId)
            ->where('status', 'pending')
            ->orderBy('scheduled_at')
            ->first();

        return view('student.dashboard', compact('stats', 'nextSession'));
    }

    // View all sessions for this student
    public function sessions()
    {
        $sessions = CounselingSession::with('counselor')
            ->where('student_id', Auth::id())
            ->latest('scheduled_at')
            ->get();

        return view('student.sessions', compact('sessions'));
    }

    // Cancel a session
    public function cancelSession(CounselingSession $session)
    {
        // Security: make sure this session belongs to the logged-in student
        if ($session->student_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Can only cancel pending sessions
        if ($session->status !== 'pending') {
            return redirect()->back()->with('error', 'You can only cancel pending sessions.');
        }

        $session->update(['status' => 'cancelled']);
        return redirect('/student/sessions')->with('success', 'Session cancelled successfully.');
    }
}
