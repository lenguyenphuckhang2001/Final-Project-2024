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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['free', 'premium']);
            $table->string('name');
            $table->double('price');
            $table->integer('limit_days');
            $table->integer('limit_listing');
            $table->integer('limit_photos');
            $table->integer('limit_video');
            $table->integer('limit_amenities');
            $table->integer('limit_featured_listing');
            $table->boolean('display_at_home');
            $table->boolean('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
