<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('form_type', ['press', 'exhibitor', 'volunteer', 'vip', 'custom'])->default('custom');
            $table->json('fields'); // Structure des champs du formulaire
            $table->json('settings')->nullable(); // Paramètres (confirmation email, redirection, etc.)
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_approval')->default(false);
            $table->integer('submissions_count')->default(0);
            $table->timestamps();
            
            $table->index(['organizer_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_forms');
    }
};
