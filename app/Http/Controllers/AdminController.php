<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CounselingSession;

class AdminController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'students'          => User::where('role', 'student')->count(),
            'counselors'        => User::where('role', 'counselor')->count(),
            'pendingSessions'   => CounselingSession::where('status', 'pending')->count(),
            'completedSessions' => CounselingSession::where('status', 'completed')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    // ── Students ──────────────────────────────────────────────────────
    public function students()
    {
        $students = User::where('role', 'student')->latest()->get();
        return view('admin.students', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.student-create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'student_id' => 'required|string|unique:users',
            'course'     => 'required|string',
            'year_level' => 'required|string',
            'contact'    => 'nullable|string',
            'password'   => 'required|string|min:6',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'student',
            'student_id' => $request->student_id,
            'course'     => $request->course,
            'year_level' => $request->year_level,
            'contact'    => $request->contact,
        ]);

        return redirect('/admin/students')
            ->with('success', 'Student registered! They can now log in using: ' . $request->email . ' / ' . $request->password);
    }

    public function deleteStudent(User $user)
    {
        $user->delete();
        return redirect('/admin/students')->with('success', 'Student deleted.');
    }

    // ── Counselors ────────────────────────────────────────────────────
    public function counselors()
    {
        $counselors = User::where('role', 'counselor')->latest()->get();
        return view('admin.counselors', compact('counselors'));
    }

    public function createCounselor()
    {
        return view('admin.counselor-create');
    }

    public function storeCounselor(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'contact'  => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'counselor',
            'contact'  => $request->contact,
        ]);

        return redirect('/admin/counselors')
            ->with('success', 'Counselor registered! They can now log in using: ' . $request->email . ' / ' . $request->password);
    }

    public function deleteCounselor(User $user)
    {
        $user->delete();
        return redirect('/admin/counselors')->with('success', 'Counselor deleted.');
    }

    // ── Sessions ──────────────────────────────────────────────────────
    public function sessions()
    {
        $sessions   = CounselingSession::with(['student', 'counselor'])->latest()->get();
        $students   = User::where('role', 'student')->get();
        $counselors = User::where('role', 'counselor')->get();
        return view('admin.sessions', compact('sessions', 'students', 'counselors'));
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:users,id',
            'counselor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date',
            'concern'      => 'nullable|string',
        ]);

        CounselingSession::create($request->only(['student_id', 'counselor_id', 'scheduled_at', 'concern']));

        return redirect('/admin/sessions')->with('success', 'Session scheduled successfully!');
    }

    // ── Reports ───────────────────────────────────────────────────────
    public function reports()
    {
        $summary = CounselingSession::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $recentSessions = CounselingSession::with(['student', 'counselor'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.reports', compact('summary', 'recentSessions'));
    }
}