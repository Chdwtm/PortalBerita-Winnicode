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
        Schema::create('berita_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained()->onDelete('cascade');
            $table->string('language', 5);
            $table->string('title');
            $table->text('content');
            $table->string('meta_description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();

            $table->unique(['berita_id', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_translations');
    }
};
