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
        Schema::table('students', function (Blueprint $table) {
            $table->string('school')->nullable();
            $table->string('sex')->nullable();
            $table->integer('age')->nullable();
            $table->string('adviser')->nullable();
            $table->string('blood_type')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->json('allergies')->nullable();
            $table->json('medical_conditions')->nullable();
            $table->json('family_history')->nullable();
            $table->boolean('smoke_exposure')->nullable();
            $table->json('medication')->nullable();
            $table->json('parent_certification')->nullable();
            $table->decimal('bmi', 5, 2)->nullable();
            $table->boolean('has_allergies')->nullable();
            $table->boolean('has_medical_condition')->nullable();
            $table->boolean('has_surgery')->nullable();
            $table->text('surgery_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'school', 'sex', 'age', 'adviser', 'blood_type', 'height', 'weight',
                'temperature', 'blood_pressure', 'allergies', 'medical_conditions',
                'family_history', 'smoke_exposure', 'medication', 'parent_certification',
                'bmi', 'has_allergies', 'has_medical_condition', 'has_surgery', 'surgery_details'
            ]);
        });
    }
};
