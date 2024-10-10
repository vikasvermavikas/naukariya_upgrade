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
        Schema::create('tracker_interviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tracker_id');
            $table->bigInteger('job_id');
            $table->string('interview_date');
            $table->longText('interview_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracker_interviews');
    }
};
