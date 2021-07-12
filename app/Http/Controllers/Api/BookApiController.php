<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCollection;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    private $perPage = 20;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'sometimes|numeric|between:1,100'
        ]);

        $books = Book::query();

		if ($request->has('maturita')) {
			$books = $books->where('maturita', true);
		}

        if ($request->has('children')) {
            $id = BookCollection::where('name', "Dětská knihovna")->value('id');
			$books = $books->where('book_collection_id', $id);
		}

        if ($request->has('available')) {
			$books = $books->whereDoesntHave('borrows', function($query) {
                $query->where('returned', false);
            })->whereDoesntHave('reservations', function($query) {
                $query->where('reserved_until', '>', now());
            });
		}

		if ($request->filled('q')) {
			$books = $books
                ->where('title', 'like', "%{$request->get('q')}%")
				->orWhere('author', 'like', "%{$request->get('q')}%")
				->orWhere('isbn', 'like', "%{$request->get('q')}%");
		}

        $perPage = $request->get('paginate', $this->perPage);

        $books = $books->orderBy('author_last_name')
            ->orderBy('author_first_name')
            ->orderBy('author_middle_name')
            ->paginate($perPage)
            ->withQueryString();

		return $books;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

		return ['status' => 'Kniha byla smazána'];
    }
}
