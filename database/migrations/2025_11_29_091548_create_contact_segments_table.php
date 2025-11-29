<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['auto', 'manual'])->default('auto');
            $table->json('criteria')->nullable(); // Critères pour segments automatiques
            $table->integer('contacts_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_segment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->foreignId('segment_id')->constrained('segments')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['contact_id', 'segment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_segment');
        Schema::dropIfExists('segments');
    }
};
