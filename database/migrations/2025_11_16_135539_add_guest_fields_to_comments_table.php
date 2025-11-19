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
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'guest_name')) {
                $table->string('guest_name', 255)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('comments', 'guest_email')) {
                $table->string('guest_email', 255)->nullable()->after('guest_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'guest_name')) {
                $table->dropColumn('guest_name');
            }
            if (Schema::hasColumn('comments', 'guest_email')) {
                $table->dropColumn('guest_email');
            }
        });
    }
};
