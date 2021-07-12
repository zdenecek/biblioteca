<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class LoggedUserController extends Controller
{
	public function ShowCurrentBorrowsReservations(Request $request)
	{
		$id = $request->user()->id;

		$borrows = Borrow::whereHas('user', function ($query) use ($id) {
			$query->where('id', $id);
		})
		->orderBy('created_at', 'desc')
		->where('returned', false)
		->get();

		$reservations = Reservation::active()
        ->whereHas('user', function ($query) use ($id) {
			$query->where('id', $id);
		})->orderBy('created_at', 'desc')
		->get();

		return view('user.current_borrows_reservations', [
			'borrows' => $borrows,
			'reservations' => $reservations]);
	}

	public function showSettings(Request $request)
	{
		return view('user.settings', ['user' => $request->user()]);
	}

	public function changePassword(Request $request)
	{
        $request->validate([
            'password' => 'string|min:8|confirmed',
        ]);
        $request->user()->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60)
        ])->save();

        return redirect()->back()
            ->with('notifications', [['type' => 'success', 'message' => "Heslo bylo úspěšně změněno"]]);

	}


    public function changeEmail(Request $request)
	{
        $request->validate([
            'email' => 'required|email|unique:App\Models\User,email'
        ]);
        $request->user()->fill([
            'email' => $request->email
        ])->save();

        return redirect()->back()
            ->with('notifications', [['type' => 'success', 'message' => "Email byl úspěšně změněn"]]);

	}

    public function showCode(Request $request)
    {
        return view('user.code', ['code' => $request->user()->code]);
    }
}
