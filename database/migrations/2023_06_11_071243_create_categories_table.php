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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_category_id')->nullable();
            $table->string('name',30);
            $table->string('slug',30);
            $table->text('description')->nullable();
            $table->text('meta_tag_description')->nullable();
            $table->string('meta_tag_keywords')->nullable();
            $table->string('lang',10);
            $table->string('post_type',20);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('parent_category_id')->references('id')->on('categories')
            ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('created_by')->references('id')->on('users')
            ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unique(['name','post_type','lang']);
            $table->unique(['slug','post_type','lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
