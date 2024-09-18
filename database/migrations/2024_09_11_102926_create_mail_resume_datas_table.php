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
        Schema::create('mail_resume_datas', function (Blueprint $table) {
            $table->id();
            $table->string('mailid');
            $table->text('jobid');
            $table->text('attachmentid');
            $table->string('filename');
            $table->string('status');
            $table->string('candidate_name')->nullable();
            $table->string('candidate_email')->nullable();
            $table->string('candidate_phone')->nullable();
            $table->longtext('candidate_address')->nullable();
            $table->longtext('skills')->nullable();
            $table->longtext('candidate_spoken_languages')->nullable();
            $table->longtext('education_qualifications')->nullable();
            $table->longtext('positions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_resume_datas');
    }
};
