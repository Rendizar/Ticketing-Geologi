<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pelajar',
                'code' => 'pelajar',
                'price' => 2000,
                'description' => 'Tiket untuk pelajar (TK, SD, SMP, SMA, Kuliah)',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Umum',
                'code' => 'umum',
                'price' => 3000,
                'description' => 'Tiket untuk pengunjung umum',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Wisatawan Asing',
                'code' => 'asing',
                'price' => 10000,
                'description' => 'Tiket untuk wisatawan asing (luar negeri)',
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($categories as $category) {
            TicketCategory::create($category);
        }
    }
}

