<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_sections')->insertOrIgnore([
            ['id'=> 1 , 'order' => 1, 'name' => 'Světová a česká literatura do konce 18. století'],
            ['id'=> 2 , 'order' => 2, 'name' => 'Světová a česká literatura 19. Století'],
            ['id'=> 3 , 'order' => 3, 'name' => 'Světová literatura 20. a 21. století'],
            ['id'=> 4 , 'order' => 4, 'name' => 'Česká literatura 20. a 21. století'],

        ]);
    }
}
