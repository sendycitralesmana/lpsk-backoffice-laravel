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
        Schema::create('roadmap_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('roadmap_id')->nullable();
            $table->foreign('roadmap_id')->references('id')->onDelete('set null')->on('roadmaps');
            $table->string('name');
            $table->string('size')->nullable();
            $table->string('extension')->nullable();
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmap_images');
    }
};
