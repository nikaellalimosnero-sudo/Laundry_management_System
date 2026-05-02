<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CounselingSession;

// This seeder fills your database with sample/test data
// Run with: php artisan db:seed
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Create Admin ──────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@school.com',
            'password' => Hash::make('password'),   // Always hash passwords!
            'role'     => 'admin',
        ]);

        // ── Create Counselors ─────────────────────────────────────────
        $counselor1 = User::create([
            'name'     => 'Ma. Santos',
            'email'    => 'counselor@school.com',
            'password' => Hash::make('password'),
            'role'     => 'counselor',
            'contact'  => '09171234567',
        ]);

        $counselor2 = User::create([
            'name'     => 'Mr. Reyes',
            'email'    => 'reyes@school.com',
            'password' => Hash::make('password'),
            'role'     => 'counselor',
            'contact'  => '09189876543',
        ]);

        // ── Create Students ───────────────────────────────────────────
        $student1 = User::create([
            'name'       => 'Juan dela Cruz',
            'email'      => 'student@school.com',
            'password'   => Hash::make('password'),
            'role'       => 'student',
            'student_id' => '2021-00001',
            'course'     => 'BSIT',
            'year_level' => '3rd Year',
            'contact'    => '09201112222',
        ]);

        $student2 = User::create([
            'name'       => 'Maria Clara',
            'email'      => 'maria@school.com',
            'password'   => Hash::make('password'),
            'role'       => 'student',
            'student_id' => '2021-00002',
            'course'     => 'BSCS',
            'year_level' => '2nd Year',
            'contact'    => '09203334444',
        ]);

        // ── Create Sample Sessions ────────────────────────────────────
        CounselingSession::create([
            'student_id'   => $student1->id,
            'counselor_id' => $counselor1->id,
            'scheduled_at' => now()->addDays(2),
            'concern'      => 'Academic Performance',
            'status'       => 'pending',
        ]);

        CounselingSession::create([
            'student_id'   => $student2->id,
            'counselor_id' => $counselor1->id,
            'scheduled_at' => now()->addDays(5),
            'concern'      => 'Career Guidance',
            'status'       => 'pending',
        ]);

        CounselingSession::create([
            'student_id'   => $student1->id,
            'counselor_id' => $counselor2->id,
            'scheduled_at' => now()->subDays(3),
            'concern'      => 'Personal Issues',
            'notes'        => 'Student seems to be dealing with stress. Follow-up recommended.',
            'status'       => 'completed',
        ]);
    }
}
