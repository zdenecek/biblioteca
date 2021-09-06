<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Reservation;
use App\Models\User;
use Exception;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers(50);
        $this->createBooks(100);
        $this->createBorrows(20);
        $this->createReservations(20);

        $book = Book::find(1);
		if ($book) {
			$book->code = 'kod';
			$book->save();
		}
    }

    private function createUsers($count)
    {
        User::factory()
            ->count($count)
            ->create();
    }

    private function createBooks($count)
    {
        Book::factory()
            ->count($count)
            ->create();
    }

    private function createBorrows($count)
    {
        $librarian = User::find(1);
        $users = User::all()->random($count);
        $books = Book::doesntHave('reservations')->get()->random($count);


        for($i = 0; $i < $count; $i++)
        {
            $book = $books->get($i);
            if($book->is_borrowed) continue;
            Borrow::make($book, $users->get($i), $librarian);
            if(random_int(0,1)) $books->get($i)->return();
        }
    }

    private function createReservations($count)
    {
        $users = User::all()->random($count);
        $books = Book::doesntHave('borrows')->get()->random($count);

        for($i = 0; $i < $count; $i++)
        {
			try {
                Reservation::make($books->get($i), $users->get($i));
			} catch (Exception $e) {

            }
        }
    }
}
