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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('XOF');
            $table->enum('payment_method', ['mobile_money', 'bank_transfer', 'crypto'])->default('mobile_money');
            
            // Mobile Money
            $table->string('mobile_network')->nullable(); // MTN, Moov, Orange, etc.
            $table->string('country_code')->nullable(); // +229, +33, etc.
            $table->string('phone_number')->nullable();
            
            // Bank Transfer
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift_code')->nullable();
            
            // Crypto
            $table->string('crypto_currency')->nullable(); // BTC, ETH, USDT, etc.
            $table->string('crypto_wallet_address')->nullable();
            $table->string('crypto_network')->nullable(); // ERC20, TRC20, BEP20, etc.
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
