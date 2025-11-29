<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('automations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('trigger_type', ['ticket_purchased', 'cart_abandoned', 'before_event', 'after_event', 'vote_cast', 'donation_made', 'custom'])->default('custom');
            $table->json('trigger_conditions')->nullable();
            $table->enum('action_type', ['send_email', 'add_tag', 'assign_to', 'update_stage', 'create_task'])->default('send_email');
            $table->json('action_config')->nullable();
            $table->integer('delay_minutes')->default(0); // Délai avant exécution
            $table->boolean('is_active')->default(true);
            $table->integer('executed_count')->default(0);
            $table->timestamp('last_executed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('automation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('automation_id')->constrained('automations')->onDelete('cascade');
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->onDelete('set null');
            $table->string('triggered_by_type')->nullable(); // ticket, vote, etc.
            $table->unsignedBigInteger('triggered_by_id')->nullable();
            $table->enum('status', ['pending', 'executed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('executed_at')->nullable();
            $table->timestamps();
            
            $table->index(['automation_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_logs');
        Schema::dropIfExists('automations');
    }
};
