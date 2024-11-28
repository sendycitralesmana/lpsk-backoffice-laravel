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
        Schema::create('news_videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('news_id')->nullable();
            $table->foreign('news_id')->references('id')->onDelete('set null')->on('news');
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
        Schema::dropIfExists('news_videos');
    }
};
