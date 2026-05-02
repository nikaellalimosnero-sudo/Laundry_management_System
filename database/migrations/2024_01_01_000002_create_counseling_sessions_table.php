<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This creates the COUNSELING_SESSIONS table
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();

            // Foreign keys link to the users table
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('counselor_id')->constrained('users')->onDelete('cascade');

            $table->dateTime('scheduled_at');                   // When the session is scheduled
            $table->string('concern')->nullable();              // What the session is about
            $table->text('notes')->nullable();                  // Counselor's notes after session

            // Status: pending → ongoing → completed (or cancelled)
            $table->enum('status', ['pending', 'ongoing', 'completed', 'cancelled'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counseling_sessions');
    }
};
