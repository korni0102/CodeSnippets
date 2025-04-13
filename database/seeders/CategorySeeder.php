<?php

namespace Database\Seeders;

use App\Models\RowCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 22; $i++) {
            RowCategory::create([
                'type' => $i
            ]);
        }
    }
}
