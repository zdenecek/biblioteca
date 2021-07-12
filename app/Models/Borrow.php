<?php

namespace App\Models;

use App\Events\BookBorrowed;
use App\Events\BookReturned;
use App\Helpers\Settings;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrow extends Model
{
	use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'librarian_id',
        'borrowed_until',
        'book_id'
    ];

	protected $attributes = [
		'returned_at' => null,
		'returned' => false,
	];

	protected $casts = [
		'borrowed_until' => 'datetime',
		'returned_at' => 'datetime',
		'returned' => 'boolean',
	];

	public static function make(Book $book, User $user, User $librarian)
	{
		if ($book->is_borrowed)
            return (object)[
                'success' => false,
                'message' => 'Knihu nelze vypůjčit, je již vypůjčená'
            ];

        if(($result = $user->canBorrow($book)) !== true)
            return (object)[
                'success' => false,
                'message' => $result
            ];

		$borrow = Borrow::create([
			'user_id' => $user->id,
			'librarian_id' => $librarian->id,
			'book_id' => $book->id,
			'borrowed_until' => now()->addDays(Settings::get('borrow_time')),
		]);

        BookBorrowed::dispatch($borrow);

		return (object)[
            'success' => true,
			'message' => 'Kniha byla úspěšně vypůjčena',
			'borrow' => $borrow
		];
	}

	public function return()
	{
		$this->returned = true;
		$this->returned_at = now();
		$this->save();

        BookReturned::dispatch($this);

		return (object)[
            'success' => true,
			'message' => 'Kniha byla úspěšně vrácena',
			'borrow' => $this
		];
	}

	public function isAfterDue()
	{
		return $this->borrowed_until->lte(now()) && $this->returned === false;
	}

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
	 * return the librarian responsible for the borrow
	 */
	public function librarian()
	{
		return $this->belongsTo(User::class, 'librarian_id')->withTrashed();
	}
}
