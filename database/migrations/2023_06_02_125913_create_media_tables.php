<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            
            $table->id();
            $table->string('status')->default('public'); // public/private
            $table->unsignedBigInteger('uploaded_by');
            $table->string('file_name');
            $table->string('collection_name')->nullable();

            $table->string('name')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('disk')->nullable();
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('manipulations')->nullable();
            $table->json('custom_properties')->nullable();
            $table->json('generated_conversions')->nullable();
            $table->json('responsive_images')->nullable();
            $table->unsignedInteger('order_column')->nullable()->index();

            $table->nullableTimestamps();


            $table->foreign('uploaded_by')->references('id')->on('users');
        });

        Schema::create('media_object', function (Blueprint $table) {

            $table->string('object_type');
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('media_id');
            $table->string('media_type');
            $table->unsignedBigInteger('order');

            $table->foreign('media_id')->references('id')->on('media');
            // ->cascadeOnUpdate()->restrictOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_object');
        Schema::dropIfExists('media');
    }
};