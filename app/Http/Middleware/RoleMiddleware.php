<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        // Not logged in — redirect to that role's login page
        if (!Auth::check()) {
            return redirect('/login/' . $role)->with('error', 'Please log in to continue.');
        }

        // Logged in but wrong role — send them to their own dashboard
        if (Auth::user()->role !== $role) {
            return match(Auth::user()->role) {
                'admin'     => redirect('/admin/dashboard'),
                'counselor' => redirect('/counselor/dashboard'),
                'student'   => redirect('/student/dashboard'),
                default     => redirect('/login'),
            };
        }

        return $next($request);
    }
}
