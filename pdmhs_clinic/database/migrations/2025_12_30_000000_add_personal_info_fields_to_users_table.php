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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->date('birthday')->nullable()->after('last_name');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birthday');
            $table->text('address')->nullable()->after('gender');
            $table->string('contact_number')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'middle_name', 
                'last_name',
                'birthday',
                'gender',
                'address',
                'contact_number'
            ]);
        });
    }
};