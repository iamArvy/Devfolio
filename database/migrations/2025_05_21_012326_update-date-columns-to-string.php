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
        Schema::table('certifications', function (Blueprint $table){
            $table->string('date_acquired')->change();
        });

        Schema::table('experiences', function (Blueprint $table){
            $table->string('start_date')->change();
            $table->string('end_date')->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certifications', function (Blueprint $table){
            $table->date('date_acquired')->change();
        });

        Schema::table('experiences', function (Blueprint $table){
            $table->date('start_date')->change();
            $table->date('end_date')->change();
        });
    }
};
