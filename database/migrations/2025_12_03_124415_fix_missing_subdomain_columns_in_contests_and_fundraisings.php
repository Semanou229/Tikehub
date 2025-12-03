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
        // Ajouter les colonnes subdomain et subdomain_enabled à contests si elles n'existent pas
        if (!Schema::hasColumn('contests', 'subdomain')) {
            Schema::table('contests', function (Blueprint $table) {
                $table->string('subdomain')->nullable()->unique();
            });
        }
        
        if (!Schema::hasColumn('contests', 'subdomain_enabled')) {
            Schema::table('contests', function (Blueprint $table) {
                if (Schema::hasColumn('contests', 'subdomain')) {
                    $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
                } else {
                    $table->boolean('subdomain_enabled')->default(false);
                }
            });
        }

        // Ajouter les colonnes subdomain et subdomain_enabled à fundraisings si elles n'existent pas
        if (!Schema::hasColumn('fundraisings', 'subdomain')) {
            Schema::table('fundraisings', function (Blueprint $table) {
                $table->string('subdomain')->nullable()->unique();
            });
        }
        
        if (!Schema::hasColumn('fundraisings', 'subdomain_enabled')) {
            Schema::table('fundraisings', function (Blueprint $table) {
                if (Schema::hasColumn('fundraisings', 'subdomain')) {
                    $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
                } else {
                    $table->boolean('subdomain_enabled')->default(false);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('contests', 'subdomain_enabled')) {
            Schema::table('contests', function (Blueprint $table) {
                $table->dropColumn('subdomain_enabled');
            });
        }
        
        if (Schema::hasColumn('contests', 'subdomain')) {
            Schema::table('contests', function (Blueprint $table) {
                $table->dropColumn('subdomain');
            });
        }

        if (Schema::hasColumn('fundraisings', 'subdomain_enabled')) {
            Schema::table('fundraisings', function (Blueprint $table) {
                $table->dropColumn('subdomain_enabled');
            });
        }
        
        if (Schema::hasColumn('fundraisings', 'subdomain')) {
            Schema::table('fundraisings', function (Blueprint $table) {
                $table->dropColumn('subdomain');
            });
        }
    }
};
