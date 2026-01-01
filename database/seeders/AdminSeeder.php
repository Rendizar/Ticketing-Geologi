<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin table exists
        if (!DB::getSchemaBuilder()->hasTable('admins')) {
            $this->command->error('Table admins tidak ditemukan!');
            return;
        }

        // Check if admin already exists
        if (Admin::where('nama', 'admin')->exists()) {
            $this->command->info('Admin sudah ada di database.');
            return;
        }

        // Create default admin
        Admin::create([
            'nama' => 'admin',
            'password' => bcrypt('1234'), // Hashed password
            'status_aktif' => 1,
            'terakhir_login' => null
        ]);

        $this->command->info('Admin default berhasil dibuat (username: admin, password: 1234)');
    }
}
