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
        Schema::create('technical_terms', function (Blueprint $table) {
            $table->id();
            $table->string('term')->unique();
            $table->text('definition_en');
            $table->text('definition_id');
            $table->string('category');
            $table->json('usage_example');
            $table->string('pronunciation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_terms');
    }
};
