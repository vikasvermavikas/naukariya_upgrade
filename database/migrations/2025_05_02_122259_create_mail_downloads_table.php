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
        Schema::create('mail_downloads', function (Blueprint $table) {
            $table->id();
            $table->timestamp('mail_date')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_name')->nullable();
            $table->string('download_status')->nullable();
            $table->string('job_id')->nullable();
            $table->string('parsing_status')->nullable();
            $table->date('parsing_date')->nullable();
            $table->integer('tracker_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_downloads');
    }
};
