<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookState
{
	public $book;

	public static function make(Book $book)
	{
		$state = new BookState();
		$state->book = $book;

		return $state;
	}

	public function string(User $user = null)
	{
		$admin = $user && $user->hasRole(Role::byString('librarian'));
		$borrows = $this->book->borrows()->where('returned', false);
		$reservations = $this->book->reservations()->where('reserved_until', '>', now());
		if ($borrows->exists()) {
			$borrow = $borrows->latest()->first();
			$date = $borrow->borrowed_until->format('j. n. Y');

			return ($user && $borrow->user->id === $user->id) ?
				"Knihu máte vypůjčenou do $date"
				: ($admin ?
					"Vypůjčená uživatelem {$borrow->user->name} do $date"
					: "Vypůjčená do $date");
		} elseif ($reservations->exists()) {
			$reservation = $reservations->first();

			return ($user && $reservation->user->id === $user->id) ?
			'Knihu máte zarezervovanou'
			: ($admin ?
				"Knihu si zarezervoval {$reservation->user->name}"
				: 'Knihu si někdo zarezervoval');
		} else {
			return 'K vypůjčení ve škole';
		}
	}

	public function stringForUser(User $user = null)
	{
		$user ??= request()->user();

		return $this->string($user);
	}
}
