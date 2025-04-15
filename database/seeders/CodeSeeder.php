<?php

namespace Database\Seeders;

use App\Models\Code;
use Illuminate\Database\Seeder;


class CodeSeeder extends Seeder
{
    private const CODE_CODE_CATEGORIES = [
        //CODE_ID => CATEGORY_ID
        1 => 1,
        2 => 1,
        3 => 1,
        4 => 1,
        5 => 1,
        6 => 1,
        7 => 1,
        8 => 1,
        9 => 1,
        10 => 1,
        11 => 1,
        12 => 2,
        13 => 2,
        14 => 2,
        15 => 2,
        16 => 2,
        17 => 2,
        18 => 2,
        19 => 2,
        20 => 3,
        21 => 3,
        22 => 3,
        23 => 3,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 23; $i++) {
            Code::create([
                'user_id' => 1,
                'code_category_id' => self::CODE_CODE_CATEGORIES[$i],
                'approved' => $i % 2 == 0,
                'name' => Code::TRANS_STRING_NAME . $i,
                'description' => Code::TRANS_STRING_DESCRIPTION . $i,
            ]);
        }
    }
}
