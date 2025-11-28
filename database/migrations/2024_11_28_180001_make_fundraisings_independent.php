<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fundraisings', function (Blueprint $table) {
            // Supprimer la contrainte existante
            $table->dropForeign(['event_id']);
            $table->foreignId('event_id')->nullable()->change();
            $table->foreignId('organizer_id')->nullable()->after('event_id')->constrained('users')->onDelete('cascade');
            $table->string('cover_image')->nullable()->after('name');
            $table->string('slug')->unique()->nullable()->after('name');
            $table->boolean('is_published')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('fundraisings', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->dropColumn('organizer_id');
            $table->dropColumn('cover_image');
            $table->dropColumn('slug');
            $table->dropColumn('is_published');
            $table->foreignId('event_id')->nullable(false)->change();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }
};

