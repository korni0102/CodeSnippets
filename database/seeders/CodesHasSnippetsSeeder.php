<?php

namespace Database\Seeders;

use App\Models\Code;
use App\Models\RowCategory;
use App\Models\Snippet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Prompts\Table;

class CodesHasSnippetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = storage_path('app/public/codeHasSnippet.csv');


        if (($handle = fopen($csvPath, 'r')) !== false) {

            $headers = fgetcsv($handle, 1000, ';'); // Adjust delimiter as ';'

            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                $snippet = Snippet::whereId($data[0])->first();

                foreach (explode(',', $data[1]) as $codeId) {
                    $code = Code::whereId($codeId)->first();

                    // Insert into many-to-many table manually
                    if ($snippet && $code) {
                        DB::table('codes_has_snippets')->insert([
                            'snippet_id' => $data[0],
                            'code_id'    => $codeId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Close the file once done
            fclose($handle);
        }
    }
}
