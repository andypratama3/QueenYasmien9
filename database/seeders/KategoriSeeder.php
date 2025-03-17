<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            'Paket Reseller',
            'SkinCare',
        ];

        foreach($category as $cat) {
            Category::create([
                'name' => $cat,
            ]);
        }
    }
}
