<?php

namespace App\Listeners;

use App\Events\BookBorrowed;
use App\Events\BookReserved;
use App\Events\BookReturned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LibraryLogger
{
	public function handleBorrow(BookBorrowed $event)
	{
		Log::channel('library')
        ->info("Knihovník {$event->borrow->librarian->name} půjčil uživateli {$event->borrow->user->name}"
        . " knihu {$event->borrow->book->title} ({$event->borrow->book->code})");
	}

	public function handleReservation(BookReserved $event)
	{
		Log::channel('library')
        ->info("Uživatel {$event->reservation->user->name} si rezervoval knihu {$event->reservation->book->title} ({$event->reservation->book->code})");
	}

	public function handleReturn(BookReturned $event)
	{
        Log::channel('library')
        ->info("Uživatel {$event->borrow->user->name} vrátil knihu {$event->borrow->book->title} ({$event->borrow->book->code})");
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $events
	 * @return void
	 */
	public function subscribe($events)
	{
		$events->listen(
			BookReserved::class,
			[LibraryLogger::class, 'handleReservation']
		);

		$events->listen(
			BookBorrowed::class,
			[LibraryLogger::class, 'handleBorrow']
		);

		$events->listen(
			BookReturned::class,
			[LibraryLogger::class, 'handleReturn']
		);

		// $events->listen(
		//     'Illuminate\Auth\Events\Logout',
		//     [UserEventSubscriber::class, 'handleUserLogout']
		// );
	}
}
