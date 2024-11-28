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
        Schema::create('highlights', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('highlight_category_id')->nullable();
            $table->foreign('highlight_category_id')->references('id')->onDelete('set null')->on('highlight_categories');
            $table->uuid('news_id')->nullable();
            $table->foreign('news_id')->references('id')->onDelete('set null')->on('news');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlights');
    }
};
