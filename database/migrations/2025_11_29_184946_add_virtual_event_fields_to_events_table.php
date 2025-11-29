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
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_virtual')->default(false)->after('type');
            $table->enum('platform_type', ['google_meet', 'zoom', 'teams', 'webex', 'other'])->nullable()->after('is_virtual');
            $table->string('meeting_link')->nullable()->after('platform_type');
            $table->string('meeting_id')->nullable()->after('meeting_link');
            $table->string('meeting_password')->nullable()->after('meeting_id');
            $table->text('virtual_access_instructions')->nullable()->after('meeting_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'is_virtual',
                'platform_type',
                'meeting_link',
                'meeting_id',
                'meeting_password',
                'virtual_access_instructions',
            ]);
        });
    }
};
