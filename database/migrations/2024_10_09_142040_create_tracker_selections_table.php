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
        Schema::create('tracker_selections', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->bigInteger('job_id');
            $table->bigInteger('tracker_id');
            $table->bigInteger('employer_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracker_selections');
    }
};
