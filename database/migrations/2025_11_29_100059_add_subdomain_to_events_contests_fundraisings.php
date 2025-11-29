<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifier et ajouter subdomain_enabled si subdomain existe déjà
        if (Schema::hasColumn('events', 'subdomain') && !Schema::hasColumn('events', 'subdomain_enabled')) {
            Schema::table('events', function (Blueprint $table) {
                $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
            });
        } elseif (!Schema::hasColumn('events', 'subdomain')) {
            Schema::table('events', function (Blueprint $table) {
                $table->string('subdomain')->nullable()->unique()->after('slug');
                $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
            });
        }

        if (!Schema::hasColumn('contests', 'subdomain')) {
            Schema::table('contests', function (Blueprint $table) {
                $table->string('subdomain')->nullable()->unique()->after('slug');
                $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
            });
        } elseif (Schema::hasColumn('contests', 'subdomain') && !Schema::hasColumn('contests', 'subdomain_enabled')) {
            Schema::table('contests', function (Blueprint $table) {
                $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
            });
        }

        if (!Schema::hasColumn('fundraisings', 'subdomain')) {
            Schema::table('fundraisings', function (Blueprint $table) {
                $table->string('subdomain')->nullable()->unique()->after('slug');
                $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
            });
        } elseif (Schema::hasColumn('fundraisings', 'subdomain') && !Schema::hasColumn('fundraisings', 'subdomain_enabled')) {
            Schema::table('fundraisings', function (Blueprint $table) {
                $table->boolean('subdomain_enabled')->default(false)->after('subdomain');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('events', 'subdomain_enabled')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('subdomain_enabled');
            });
        }

        if (Schema::hasColumn('contests', 'subdomain_enabled')) {
            Schema::table('contests', function (Blueprint $table) {
                $table->dropColumn('subdomain_enabled');
            });
        }

        if (Schema::hasColumn('fundraisings', 'subdomain_enabled')) {
            Schema::table('fundraisings', function (Blueprint $table) {
                $table->dropColumn('subdomain_enabled');
            });
        }
    }
};
