<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id_login');
            $table->string('nama')->default('admin');
            $table->string('password');
            $table->tinyInteger('status_aktif')->default(1);
            $table->dateTime('terakhir_login')->nullable();
            $table->timestamps();
        });

        // Insert default admin
        DB::table('admins')->insert([
            'nama' => 'admin',
            'password' => bcrypt('1234'),
            'status_aktif' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('admins');
    }
};