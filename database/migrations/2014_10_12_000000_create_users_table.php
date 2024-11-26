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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['user', 'admin'])->default('user');
            $table->string('avatar')->default('/default/avatar.jpg');
            $table->string('banner')->default('/default/banner.jpg');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phonenumber')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->text('website')->nullable();
            $table->text('fb_url')->nullable();
            $table->text('x_url')->nullable();
            $table->text('linked_url')->nullable();
            $table->text('insta_url')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
