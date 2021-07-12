<?php

namespace App\Models;

use App\Events\BookReserved;
use App\Helpers\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    /**
     * Filter reservations that are not past due date
     * @returns Builder
     */
    public static function active()
    {
        return self::where('reserved_until', '>', now());
    }

	use HasFactory, SoftDeletes;

	protected $fillable = [
		'user_id',
		'book_id',
		'reserved_until',
	];

	protected $casts = [
		'reserved_until' => 'datetime'
	];

	public function book()
	{
		return $this->belongsTo(Book::class)->withTrashed();
	}

	/**
	 * return the user who borrowed the book
	 */
	public function user()
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

	/**
	 * @return object result
	 */
	public static function make(Book $book, User $user)
	{
		if ($book->is_borrowed) {
			return (object)[
				'success' => false,
				'message' => 'Knihu nelze rezervovat, je vypůjčená'
			];
		}

        if ($book->is_reserved) {
			return (object)[
				'success' => false,
				'message' => 'Knihu nelze rezervovat, je již rezervovaná'
			];
		}


		if (($result = $user->canReserve($book)) !== true) {
			return (object)[
				'success' => false,
				'message' => $result
			];
		}

		$reservation = Reservation::create([
			'user_id' => $user->id,
			'book_id' => $book->id,
			'reserved_until' => now()->addDays(Settings::get('reservation_time')),
		]);

        BookReserved::dispatch($reservation);

		return (object)[
			'success' => true,
			'message' => 'Kniha byla úspěšně rezervována',
			'reservation' => $reservation,
            'book' => $book
		];
	}

    public function getActiveAttribute()
    {
        return $this->reserved_until->gt(now());
    }

	/**
	 * @return object result
	 */
	public function cancel()
	{
        $this->delete();
		$this->save();

		return (object)[
			'success' => true,
			'message' => 'Rezervace byla zrušena'
		];
	}


}
