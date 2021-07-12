<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Database\Seeder;

class OneBorrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $book = Book::factory()->create();
        $user = User::find(1);

        Borrow::make($book, $user, $user);
    }
}
