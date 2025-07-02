<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('beritas', function (Blueprint $table) {
        $table->foreignId('penulis_id')->after('kategori_id')->constrained('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('beritas', function (Blueprint $table) {
        $table->dropForeign(['penulis_id']);
        $table->dropColumn('penulis_id');
    });
}

};