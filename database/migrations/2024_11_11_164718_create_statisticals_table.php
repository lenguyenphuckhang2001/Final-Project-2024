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
        Schema::create('statisticals', function (Blueprint $table) {
            $table->id();
            $table->string('background')->nullable();

            $table->string('title_first')->nullable();
            $table->integer('number_first')->nullable();

            $table->string('title_second')->nullable();
            $table->integer('number_second')->nullable();

            $table->string('title_third')->nullable();
            $table->integer('number_third')->nullable();

            $table->string('title_fourth')->nullable();
            $table->integer('number_fourth')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statisticals');
    }
};
