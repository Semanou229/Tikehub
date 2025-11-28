<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('scanned_by')->constrained('users')->onDelete('cascade');
            $table->enum('scan_type', ['entry', 'exit', 'validation'])->default('entry');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('location')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['event_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_scans');
    }
};

