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
        Schema::create('certifications', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('location');
            $table->json('highlights')->nullable();
            $table->string('date_acquired')->nullable();
            $table->string('media')->nullable();
            $table->string('link')->nullable();
            $table->foreignUuid('user_id')->unique()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('certifications');
    }
};
