<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    public function up()
    {
        // Update timestamps for kategoris
        if (Schema::hasTable('kategoris')) {
            DB::table('kategoris')
                ->whereNull('created_at')
                ->update([
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

        // Update user_id for beritas if it exists
        if (Schema::hasTable('beritas') && Schema::hasColumn('beritas', 'user_id')) {
            // Get or create admin user
            $admin = User::where('role', 'admin')->first();
            if (!$admin) {
                $admin = User::create([
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('admin123'),
                    'role' => 'admin'
                ]);
            }

            // Update beritas without user_id
            DB::table('beritas')
                ->whereNull('user_id')
                ->update(['user_id' => $admin->id]);
        }
    }

    public function down()
    {
        // No rollback needed for these updates
    }
}; 