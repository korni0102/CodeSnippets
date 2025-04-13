<?php

namespace Database\Seeders;

use App\Models\CodeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CodeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            CodeCategory::create([
                'type' => $i
            ]);
        }
    }

}
