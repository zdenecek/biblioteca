<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Reservation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BorrowController extends Controller
{
	public function ShowCurrentBorrows()
	{
		//TAKE CARE OF OR PRIORITY
		$borrows = Borrow::query()
		->when(request()->has('all') === false, function ($borrowsQuery, $value) {
			$borrowsQuery->where('returned', false);
		})
		->when(request()->filled('q'), function ($borrowQuery, $value) {
			$q = request()->get('q');
			$borrowQuery
			->whereHas('book', function ($query) use ($q) {
				$query->where('title', 'like', "%$q%")->orWhere('author', 'like', "%$q%");
			})
			->orWhereHas('user', function ($query) use ($q) {
				$query->where('name', 'like', "%$q%");
			});
		})
        ->orderBy('returned')
		->orderBy('borrowed_until')
        ->paginate(30)
        ->withQueryString();

		return view('admin.borrow.current_list')->with('borrows', $borrows);
	}

    public function borrowOrReturn(){
        return view('admin.book.borrow_or_return');
    }

    public function return(Request $request, Book $book)
	{
		return response()->json($book->return());
	}

	public function borrow(Request $request, Book $book, User $user)
	{
		if ($book->is_reserved) {
			$reservation = $book->current_reservation;
			if ($reservation->user->id === $user->id || $request->has('override_reservation')) {
				$reservation->cancel();
			}
            else
                return response()->json([
                    'success' => false,
                    'message' => 'Kniha nebyla vypůjčena z důvodu rezervace.'
                ]);
		}
        $result = Borrow::make($book, $user, $request->user());
		return response()->json($result);
	}

    public function showRecentlyReturned(Request $request)
	{
		$books = Book::whereHas('borrows', function ($query) {
			$query->whereDay('returned_at', now()->day);
		})->paginate(25);

		return view('admin.book.recently_returned', ['books' => $books]);
	}

}
