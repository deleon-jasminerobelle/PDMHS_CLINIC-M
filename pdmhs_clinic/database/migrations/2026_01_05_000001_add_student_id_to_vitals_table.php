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
        if (!Schema::hasColumn('vitals', 'student_id')) {
            Schema::table('vitals', function (Blueprint $table) {
                $table->unsignedBigInteger('student_id')->nullable()->after('id');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vitals', function (Blueprint $table) {
            if (Schema::hasColumn('vitals', 'student_id')) {
                $table->dropForeign(['student_id']);
                $table->dropColumn('student_id');
            }
        });
    }
};
