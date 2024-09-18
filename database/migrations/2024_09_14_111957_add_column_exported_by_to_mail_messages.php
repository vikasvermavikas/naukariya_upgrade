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
        Schema::table('mail_messages', function (Blueprint $table) {
            $table->bigInteger('exported_by')->after('attachment_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_messages', function (Blueprint $table) {
            $table->dropColumn('exported_by');
        });
    }
};
