<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locals = ['en', 'sk'];

        foreach ($locals as $locale) {
            $json = storage_path('app/public/' . $locale . '.json');
            $data = json_decode(file_get_contents($json), true);

            foreach ($data as $key => $value) {
                Translation::create([
                    'locale' => $locale,
                    'key'    => $key,
                    'value'  => $value,
                ]);
            }
        }
    }
}
