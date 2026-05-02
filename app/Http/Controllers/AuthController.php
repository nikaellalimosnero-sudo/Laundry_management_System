<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show portal selector
    public function showLogin()
    {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.login');
    }

    // Show role-specific LOGIN page
    public function showRoleLogin(string $role)
    {
        if (!in_array($role, ['admin', 'counselor', 'student'])) abort(404);
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.role-login', compact('role'));
    }

    // Show role-specific REGISTER page
    public function showRoleRegister(string $role)
    {
        if (!in_array($role, ['admin', 'counselor', 'student'])) abort(404);
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.role-register', compact('role'));
    }

    // Handle LOGIN
    // Works for BOTH admin-registered and self-registered users.
    // If admin registered the student/counselor with a temp password,
    // they just log in with that email + temp password. No re-registration needed.
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:admin,counselor,student',
        ]);

        // Check if email exists at all first, to give a helpful error
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->withInput($request->except('password'));
        }

        // Email exists but wrong role portal
        if ($user->role !== $request->role) {
            return back()->withErrors([
                'email' => 'This account is registered as a ' . ucfirst($user->role) . ', not a ' . ucfirst($request->role) . '. Please use the correct portal.',
            ])->withInput($request->except('password'));
        }

        // Attempt login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'email' => 'Incorrect password.',
        ])->withInput($request->except('password'));
    }

    // Handle REGISTER
    // Students must provide full info (same as what admin would enter).
    // Counselors provide name, contact, email, password.
    // Admins provide just email and password.
    public function register(Request $request)
    {
        $role = $request->role;

        // Base rules for all roles
        $rules = [
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,counselor,student',
        ];

        // Counselors need name and contact
        if ($role === 'counselor') {
            $rules['name']    = 'required|string|max:255';
            $rules['contact'] = 'nullable|string|max:20';
        }

        // Students need all fields — same as what admin would register
        if ($role === 'student') {
            $rules['name']       = 'required|string|max:255';
            $rules['student_id'] = 'required|string|unique:users,student_id';
            $rules['course']     = 'required|string';
            $rules['year_level'] = 'required|string';
            $rules['contact']    = 'nullable|string|max:20';
        }

        $request->validate($rules);

        // Build the data array
        $data = [
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $role,
            // For admin, use the part before @ as name
            'name'     => $request->name ?? explode('@', $request->email)[0],
        ];

        if ($role === 'student') {
            $data['student_id'] = $request->student_id;
            $data['course']     = $request->course;
            $data['year_level'] = $request->year_level;
            $data['contact']    = $request->contact;
        }

        if ($role === 'counselor') {
            $data['contact'] = $request->contact;
        }

        $user = User::create($data);

        // Auto-login after registering
        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    // Logout — sends back to that role's login page
    public function logout(Request $request)
    {
        $role = Auth::user()->role ?? 'student';
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login/' . $role)->with('success', 'Logged out successfully.');
    }

    private function redirectByRole()
    {
        return match(Auth::user()->role) {
            'admin'     => redirect('/admin/dashboard'),
            'counselor' => redirect('/counselor/dashboard'),
            'student'   => redirect('/student/dashboard'),
            default     => redirect('/login'),
        };
    }
}