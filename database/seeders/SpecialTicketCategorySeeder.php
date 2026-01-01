<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class SpecialTicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketCategory::create([
            'code' => 'khusus',
            'name' => 'Tiket Khusus',
            'price' => 0,
            'description' => 'Lansia, Disabilitas, Panti Asuhan, Peserta Diklat, Tamu Negara',
            'is_active' => 1,
            'sort_order' => 4,
        ]);
    }
}

