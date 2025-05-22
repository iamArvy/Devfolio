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
        Schema::table('projects', function (Blueprint $table){
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('stacks', function (Blueprint $table){
            $table->timestamps();
        });

        Schema::table('certifications', function (Blueprint $table){
            $table->timestamps();
        });

        Schema::table('experiences', function (Blueprint $table){
            $table->timestamps();
        });

        Schema::table('socials', function (Blueprint $table){
            $table->timestamps();
        });

        Schema::table('profiles', function (Blueprint $table){
            $table->unique('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table){
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });

        Schema::table('stacks', function (Blueprint $table){
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });

        Schema::table('certifications', function (Blueprint $table){
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });

        Schema::table('experiences', function (Blueprint $table){
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });

        Schema::table('socials', function (Blueprint $table){
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });

        Schema::table('profiles', function (Blueprint $table){
            $table->dropUnique(['user_id']);
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });
    }
};
