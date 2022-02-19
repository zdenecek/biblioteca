<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookCollection;
use App\Models\BookSection;
use App\Rules\IsIsbn;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function show($id)
    {
        $book = Book::withTrashed()->with('section')->findOrFail($id);
        if ($book->trashed()) {
            session()
                ->now('notifications', [['type' => 'warning', 'message' => 'Prohlížíte si smazanou knihu.']]);
        }

        if ($book->isbn) {
            $response = Http::get("https://www.googleapis.com/books/v1/volumes?q=isbn:{$book->isbn}");
            if ($response['totalItems'] === 1) {
                $book->googleBooksData = $response['items'][0];
            }
            Log::debug($book->googleBooksData);
        }

        return view('book.detail', ['book' => $book]);
    }

    public function showAdmin($id)
    {
        $book = Book::withTrashed()->findOrFail($id);
        $borrows = $book->borrows()->orderBy('created_at')->get();
        if ($book->trashed()) {
            session()->now('notifications', [['type' => 'warning', 'message' => 'Prohlížíte si smazanou knihu']]);
        }

        return view('admin.book.detail', ['book' => $book, 'borrows' => $borrows]);
    }

    public function indexAdmin(Request $request)
    {
        $books = Book::orderBy('author_last_name');

        if ($request->filled('q')) {
            $books = $books->where('title', 'like', "%{$request->get('q')}%")
                ->orWhere('isbn', 'like', "%{$request->get('q')}%")
                ->orWhere('code', 'like', "%{$request->get('q')}%")
                ->orWhere('author', 'like', "%{$request->get('q')}%");
        }

        return view('admin.book.manager', ['books' => $books->paginate(50)->withQueryString()]);
    }

    public function getBookByCode(string $code)
    {
        return Book::where('code', $code)
            ->with('reservations', 'collection', 'section')
            ->firstOrFail();
    }

    public function create()
    {
        $bookCollections = BookCollection::all(['id', 'name']);
        $bookSections = BookSection::all(['id', 'name']);

        return view('admin.book.add', [
            'collections' => $bookCollections,
            'sections' => $bookSections]);
    }

    public function edit(Book $book)
    {
        $bookCollections = BookCollection::all(['id', 'name']);
        $bookSections = BookSection::all(['id', 'name']);

        return view('admin.book.edit', [
            'book' => $book,
            'collections' => $bookCollections,
            'sections' => $bookSections
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author_last_name' => 'required|max:255',
            'author_middle_name' => 'max:255',
            'author_first_name' => 'max:255',
            'code' => 'max:255|unique:books,code',
            'isbn' => ['nullable', new IsIsbn()],
            'collection' => 'required|exists:book_collections,id',
            'section' => 'required_if:maturita,==,1',
        ]);

        $book = Book::create(
            $request->only([
			'title', 
			'author_first_name',
			'author_middle_name',
			'author_last_name',
			'code',
			'isbn',
			'maturita', ])
        );

        
		if($request->has('collection')) {
			$book->collection()->associate(BookCollection::find($request->collection));
		}

        if ($request->maturita == true) {
            $book->section()->associate(BookSection::find($request->section));
        }

        $book->save();

        return redirect()->route('admin.book.add')
        ->with('notifications', [['type' => 'success', 'message' => "Kniha {$request->title} byla úspěšně přidána"]]);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'sometimes|max:255',
            'isbn' => ['sometimes', 'nullable', new IsIsbn()],
            'author_first_name' => 'sometimes|max:255',
            'author_middle_name' => 'sometimes|max:255',
            'author_last_name' => 'sometimes|max:255',
            'collection' => 'sometimes|exists:book_collections,id',
            'code' => "sometimes|max:255|unique:books,code,{$book->id}",
            'section' => 'required_if:maturita,==,1',
        ]);
		if($request->has('collection')) {
			$book->collection()->associate(BookCollection::find($request->collection));
		}
        if ($request->maturita == true) {
            $book->section()->associate(BookSection::find($request->section));
        }

        $book->fill($request->only([
			'title', 
			'author_first_name',
			'author_middle_name',
			'author_last_name',
			'code',
			'isbn',
			'maturita', ]));

        $book->save();

        return redirect()->route('admin.book.manager')
            ->with('notifications', [['type' => 'success', 'message' => "Kniha {$book->title} byla úspěšně upravena"]]);
    }
}
