<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update all existing records to have timestamps
        DB::table('kategoris')
            ->whereNull('created_at')
            ->update([
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    public function down()
    {
        // No need for down method as we don't want to remove timestamps
    }
}; 