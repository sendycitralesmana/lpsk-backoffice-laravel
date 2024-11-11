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
        Schema::create('roadmap_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roadmap_id')->nullable();
            $table->foreign('roadmap_id')->references('id')->onDelete('set null')->on('roadmaps');
            $table->string('name');
            $table->string('size');
            $table->string('extension');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmap_videos');
    }
};
