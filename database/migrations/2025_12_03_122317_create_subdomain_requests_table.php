<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subdomain_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('requested_subdomain'); // Le sous-domaine demandé par l'organisateur
            $table->enum('content_type', ['event', 'contest', 'fundraising']);
            $table->unsignedBigInteger('content_id'); // ID de l'événement, concours ou collecte
            $table->text('reason')->nullable(); // Raison de la demande
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('admin_notes')->nullable(); // Notes de l'admin
            $table->string('actual_subdomain')->nullable(); // Le sous-domaine réel créé sur cPanel par l'admin
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Index pour les recherches
            $table->index('status');
            $table->index(['content_type', 'content_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdomain_requests');
    }
};
