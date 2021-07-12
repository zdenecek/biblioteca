<?php

namespace Database\Seeders;

use App\Models\BookCollection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_collections')->insertOrIgnore([
                ['id'=> 1 , 'name' => 'Školní knihovna'],
                ['id'=> 2 , 'name' => 'Dětská knihovna'],
                ['id'=> 3 , 'name' => 'Maturitní četba'],
                ['id'=> 4 , 'name' => 'Sbírka paní ředitelky'],
            ]);


    }
}
