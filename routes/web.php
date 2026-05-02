<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\StudentController;

// Root — portal selector
Route::get('/', fn() => view('auth.login'));

// ── Auth ──────────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login/{role}', [AuthController::class, 'showRoleLogin'])->name('login.role');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register/{role}', [AuthController::class, 'showRoleRegister'])->name('register.role');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Admin ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Students
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('admin.students.store');
    Route::delete('/students/{user}', [AdminController::class, 'deleteStudent'])->name('admin.students.delete');

    // Counselors
    Route::get('/counselors', [AdminController::class, 'counselors'])->name('admin.counselors');
    Route::get('/counselors/create', [AdminController::class, 'createCounselor'])->name('admin.counselors.create');
    Route::post('/counselors', [AdminController::class, 'storeCounselor'])->name('admin.counselors.store');
    Route::delete('/counselors/{user}', [AdminController::class, 'deleteCounselor'])->name('admin.counselors.delete');

    // Sessions
    Route::get('/sessions', [AdminController::class, 'sessions'])->name('admin.sessions');
    Route::post('/sessions', [AdminController::class, 'storeSession'])->name('admin.sessions.store');

    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

// ── Counselor ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:counselor'])->prefix('counselor')->group(function () {
    Route::get('/dashboard', [CounselorController::class, 'dashboard'])->name('counselor.dashboard');
    Route::get('/sessions', [CounselorController::class, 'sessions'])->name('counselor.sessions');
    Route::post('/sessions/{session}/conduct', [CounselorController::class, 'conductSession'])->name('counselor.conduct');
    Route::get('/sessions/{session}/notes', [CounselorController::class, 'editNotes'])->name('counselor.notes.edit');
    Route::post('/sessions/{session}/notes', [CounselorController::class, 'updateNotes'])->name('counselor.notes.update');
});

// ── Student ───────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/sessions', [StudentController::class, 'sessions'])->name('student.sessions');
    Route::post('/sessions/{session}/cancel', [StudentController::class, 'cancelSession'])->name('student.cancel');
});