<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookSection;
use App\Models\IsbnNumber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = random_int(0,1) === 1 ? "male" : "female";
        $maturita = $this->faker->boolean;
        $collection = collect([1,2,4])->random();
        $section = null;
        if($maturita)
        {
            $section = random_int(1, DB::table('book_sections')->count());
            $collection = 3;
        }

        return [
            'title' => $this->faker->realText(20),//sentence(6, true),
            'author_first_name' => $this->faker->firstName($gender),
            'author_last_name' =>  $this->faker->lastName($gender),
            'maturita' => $maturita,
            'code' => $this->faker->ean8,
            'isbn' => IsbnNumber::make($this->faker->isbn13),
            'book_collection_id' => $collection,
            'book_section_id' => $section,
        ];
    }
}
