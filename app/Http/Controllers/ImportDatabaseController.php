<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookImport;
use App\Rules\IsIsbn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportDatabaseController extends Controller
{
    public function showImport() {
        return view('admin.db.import');
    }

    public function importBooks(Request $request) {
        $request->validate([
            'import_name' => 'required|max:255',
            'books' => 'array|required',
            'books.*.title' => 'required|max:255',
			'books.*.author_last_name' => 'required|max:255',
			'books.*.author_middle_name' => 'max:255',
			'books.*.author_first_name' => 'max:255',
            'books.*.isbn' => new IsIsbn(),
			'books.*.collection' => 'required|exists:book_collections,id',
			'books.*.code' => 'max:255|unique:books,code|distinct',
			'books.*.section' => 'required_if:books.*.maturita, true',
			'books.*.maturita' => 'boolean',

        ]);

        DB::transaction(function () use ($request){
            $importId = BookImport::create(['name' => $request->import_name])->id;
            foreach($request->books as $bookData) {
                Book::create($bookData + ['book_import_id' => $importId]);
            }
        });

        $c = count($request->books);

        return response()->json(["message" => "Import proběhl úspěšně, bylo importováno $c knih."]);
    }

    public function showImportHistory()
    {
        $imports = BookImport::withCount('books')->get();

        return view('admin.db.import_history', ['imports' => $imports]);
    }
}
