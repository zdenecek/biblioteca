<?php

namespace App\Http\Controllers;

use App\Models\BookCollection;
use Illuminate\Http\Request;

class BookCollectionController extends Controller
{
    public function showAddBookCollection()
    {
        return view("admin.book_collection.add");
    }

    public function showEditBookCollection(BookCollection $collection)
    {
        return view("admin.book_collection.edit", ['collection' => $collection]);
    }

    public function addBookCollection(Request $request)
    {
        $request->validate([
			'name' => 'required|max:255',
		]);

        BookCollection::create([
            'name' => $request->name,
        ]);

        return redirect()->route("admin.web_settings")
            ->with('notifications', [['type' => 'success', 'message' => "Sbírka {$request->name} byla přidána"]]);
    }

    public function editBookCollection(Request $request, BookCollection $collection)
    {
        $request->validate([
			'name' => 'required|max:255',
		]);

		$collection->update([
			'name' => $request->name,
		]);

        return redirect()->route("admin.web_settings")
            ->with('notifications', [['type' => 'success', 'message' => "Sbírka {$request->name} byla upravena"]]);
    }
}
