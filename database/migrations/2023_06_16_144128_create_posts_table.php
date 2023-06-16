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
        Schema::create('posts', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('author_id');
            $table->string('lang',10);
            $table->string('post_type',20);
            $table->string('post_status',20);
            $table->string('title');
            $table->string('slug');

            $table->text('meta_tag_description')->nullable();
            $table->string('meta_tag_keywords')->nullable();
            $table->longText('content')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('scheduled_publish_date')->nullable();
            $table->unsignedBigInteger('total_views')->nullable();

            $table->boolean('featured')->default(false)->nullable();
            $table->integer('featured_order')->nullable();
            $table->boolean('recomended')->default(false)->nullable();
            $table->integer('recomended_order')->nullable();
            $table->boolean('breaking')->default(false)->nullable();
            $table->integer('breaking_order')->nullable();

            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories')
            ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('author_id')->references('id')->on('users')
            ->cascadeOnUpdate()->restrictOnDelete();


            $table->unique(['title','post_type','lang']);
            $table->unique(['slug','post_type','lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
