<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
	public function showCurrentReservations()
	{
		$reservations = Reservation::active()
            ->when(request()->filled('q'), function ($reservationQuery, $value) {
                $q = request()->get('q');
                $reservationQuery
                    ->whereHas('book', function ($query) use ($q) {
                        $query->where('title', 'like', "%$q%")->orWhere('author', 'like', "%$q%");
                    })
                    ->orWhereHas('user', function ($query) use ($q) {
                        $query->where('name', 'like', "%$q%");
                    });
            })->get();

		return view('admin.reservation.current_list', ['reservations' => $reservations]);
	}

	public function clearReservations()
	{
		Reservation::all()->map( function($res) {$res->delete();});

		return back()
            ->with('notifications', [['type' => 'success', 'message' => "Rezervace byly smazány"]]);

	}

	public function reserveBook(Request $request, Book $book)
	{
		$user = $request->user();
		$result = Reservation::make($book, $user);

		return redirect()->back()->with('notifications', [[
            'type' => $result->success? 'success' : 'error',
            'message' => $result->message]] );

	}
}
