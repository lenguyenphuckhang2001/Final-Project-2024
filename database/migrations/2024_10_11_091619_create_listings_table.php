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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('package_id')->nullable();

            $table->string('image');
            $table->string('thumbnail');
            $table->string('title');
            $table->string('slug');
            $table->string('phonenumber');
            $table->string('email');
            $table->string('address');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->string('file')->nullable();

            $table->integer('views')->default(0);

            $table->text('description');
            $table->text('map_embed_code')->nullable();
            $table->text('website')->nullable();
            $table->text('fb_url')->nullable();
            $table->text('x_url')->nullable();
            $table->text('linked_url')->nullable();
            $table->text('insta_url')->nullable();

            $table->boolean('is_verified')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('status')->default(1);

            $table->date('expire_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
