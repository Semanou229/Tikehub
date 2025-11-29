<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('job_title')->nullable();
            $table->enum('category', ['participant', 'sponsor', 'staff', 'press', 'vip', 'partner', 'prospect', 'other'])->default('participant');
            $table->enum('pipeline_stage', ['prospect', 'confirmed', 'partner', 'closed'])->default('prospect');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('next_follow_up_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['organizer_id', 'category']);
            $table->index(['organizer_id', 'pipeline_stage']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
