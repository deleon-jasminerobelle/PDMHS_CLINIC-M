<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medical_visits', function (Blueprint $table) {
            $table->id('visit_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('clinic_staff_id')->nullable();
            $table->datetime('visit_datetime');
            $table->enum('visit_type', ['Routine', 'Emergency', 'Follow-up', 'Referral'])->default('Routine');
            $table->string('chief_complaint', 255)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Open', 'Closed', 'Referred'])->default('Open');
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('student_id');
            $table->index('clinic_staff_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_visits');
    }
};