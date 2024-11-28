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
        Schema::create('informations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('information_category_id')->nullable();
            $table->foreign('information_category_id')->references('id')->onDelete('set null')->on('information_categories');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('slug');
            $table->string('title');
            $table->text('content');
            $table->string('cover')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informations');
    }
};
