<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('set null');
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->onDelete('set null');
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('sponsor_type', ['gold', 'silver', 'bronze', 'partner', 'media', 'other'])->default('other');
            $table->decimal('contribution_amount', 15, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->text('benefits')->nullable(); // Avantages accordés
            $table->json('deliverables')->nullable(); // Livrables (logo, stand, etc.)
            $table->enum('status', ['prospect', 'negotiating', 'confirmed', 'delivered', 'closed'])->default('prospect');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['organizer_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
