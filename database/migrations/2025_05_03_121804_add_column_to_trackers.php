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
        Schema::table('trackers', function (Blueprint $table) {
            $table->enum('import_type', ['manual', 'auto'])->nullable()->default('manual')->after('active');
            $table->integer('import_id')->comment('if import type is auto then import id is the id of mail download table')->nullable()->after('import_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trackers', function (Blueprint $table) {
            $table->dropColumn(['import_type', 'import_id']);
        });
    }
};
