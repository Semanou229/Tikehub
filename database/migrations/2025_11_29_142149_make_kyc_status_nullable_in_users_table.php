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
        // Modifier la colonne kyc_status pour qu'elle soit nullable
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `kyc_status` ENUM('pending', 'verified', 'rejected') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre la valeur par défaut
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `kyc_status` ENUM('pending', 'verified', 'rejected') NULL DEFAULT 'pending'");
    }
};
