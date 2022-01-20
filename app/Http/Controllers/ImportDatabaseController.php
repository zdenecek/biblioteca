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
            'books.*.isbn' => ['sometimes', 'nullable', new IsIsbn()],
			'books.*.collection' => 'required|exists:book_collections,id',
			'books.*.code' => 'max:255|unique:books,code|distinct',
			'books.*.maturita' => 'sometimes|nullable|boolean',
			'books.*.book_section_id' => 'required_if:books.*.maturita,1|nullable|exists:book_sections,id',

        ]);

        

        DB::transaction(function () use ($request){
            $importId = BookImport::create(['name' => $request->import_name])->id;
            foreach($request->books as $bookData) {
                
                Book::create($bookData + ['book_import_id' => $importId,
                 'book_collection_id' => $bookData['collection']]);
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
