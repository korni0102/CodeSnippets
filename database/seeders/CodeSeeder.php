<?php

namespace Database\Seeders;

use App\Models\Code;
use Illuminate\Database\Seeder;


class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Code::create([
                'user_id'          => 1,
                'code_category_id' => $i % 2 == 0 ? 1 : 2,
                'approved'         => $i % 2 == 0,
                'name'             => 'Code #'.$i + 1,
                'description'      => 'Description #'.$i + 1,
            ]);
        }
    }
}
