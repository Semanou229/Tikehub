<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('set null');
            $table->string('paymentable_type')->nullable();
            $table->unsignedBigInteger('paymentable_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('XOF');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('payment_method')->default('moneroo');
            $table->string('moneroo_transaction_id')->nullable()->unique();
            $table->string('moneroo_reference')->nullable()->unique();
            $table->decimal('platform_commission', 10, 2)->default(0);
            $table->decimal('organizer_amount', 10, 2)->default(0);
            $table->json('metadata')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamps();
            
            $table->index(['paymentable_type', 'paymentable_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

