<?php

namespace Database\Seeders;

use App\Models\DictionaryTag;
use Illuminate\Database\Seeder;

class DictionaryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dictionary_tags')->insert([
            'name' => "oxford cefr 3000",
            'description' => "The list of the most frequent words according to Oxford dictionary.",
        ]);
    }
}
