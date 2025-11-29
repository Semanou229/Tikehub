<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->string('group')->default('general'); // general, payment, commission, email, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Insérer les paramètres par défaut
        DB::table('platform_settings')->insert([
            ['key' => 'platform_name', 'value' => 'Tikehub', 'type' => 'string', 'group' => 'general', 'description' => 'Nom de la plateforme'],
            ['key' => 'platform_email', 'value' => 'contact@tikehub.com', 'type' => 'string', 'group' => 'general', 'description' => 'Email de contact'],
            ['key' => 'platform_phone', 'value' => '+229 90 00 00 00', 'type' => 'string', 'group' => 'general', 'description' => 'Téléphone de contact'],
            ['key' => 'commission_rate', 'value' => '5', 'type' => 'integer', 'group' => 'commission', 'description' => 'Taux de commission en pourcentage'],
            ['key' => 'min_withdrawal_amount', 'value' => '1000', 'type' => 'integer', 'group' => 'payment', 'description' => 'Montant minimum de retrait (XOF)'],
            ['key' => 'max_withdrawal_amount', 'value' => '10000000', 'type' => 'integer', 'group' => 'payment', 'description' => 'Montant maximum de retrait (XOF)'],
            ['key' => 'withdrawal_processing_days', 'value' => '3', 'type' => 'integer', 'group' => 'payment', 'description' => 'Délai de traitement des retraits (jours)'],
            ['key' => 'kyc_required_for_withdrawal', 'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'description' => 'KYC obligatoire pour les retraits'],
            ['key' => 'max_votes_per_user', 'value' => '100', 'type' => 'integer', 'group' => 'contests', 'description' => 'Nombre maximum de votes par utilisateur'],
            ['key' => 'max_votes_per_ip', 'value' => '1000', 'type' => 'integer', 'group' => 'contests', 'description' => 'Nombre maximum de votes par IP'],
            ['key' => 'vote_cooldown_minutes', 'value' => '1', 'type' => 'integer', 'group' => 'contests', 'description' => 'Délai entre deux votes (minutes)'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
    }
};
