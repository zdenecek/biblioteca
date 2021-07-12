<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCollection;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    private $perPage = 20;

    public function ShowCatalog(Request $request)
	{
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

        $books = $books->orderBy('author_last_name')
            ->orderBy('author_first_name')
            ->orderBy('author_middle_name')
            ->paginate($this->perPage)
            ->withQueryString();

		return view('book.catalog', ['books' => $books]);
	}
}
