<?php

namespace App\Models;

use App\Casts\HyphenatedStringToIsbn;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Book extends Model
{
	use HasFactory, SoftDeletes;

    protected static function booted()
	{
		static::deleted(function ($book) {
			$book->borrows->each(function($borrow) {
                $borrow->delete();
            });
			$book->reservations->each(function($reservation) {
                $reservation->delete();
            });
		});
	}

    protected $appends = [
        'is_borrowed',
        'is_reserved',
        'current_reservation',
        'current_borrow',
        'is_available',
        'state',
        'routes',
    ];

    protected $fillable = [
        'title',
        'isbn',
        'author_first_name',
        'author_middle_name',
        'author_last_name',
        'maturita',
        'book_collection_id',
        'code',
        'book_import_id',
    ];

	protected $attributes = [
		'maturita' => false,
	];

    protected $casts = [
        'isbn' => HyphenatedStringToIsbn::class,
        'maturita' => 'boolean',
    ];

    // METHODS

    public function return()
    {
        if ($this->is_borrowed === false)
            return (object)[
                'success' => false,
                'message' => 'Kniha není vypůjčená, nelze ji vrátit',
            ];
        else
            return $this->current_borrow->return();
    }

    // RELATIONS

    public function getState()
	{
        return BookState::make($this);
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class);
	}

	public function borrows()
	{
		return $this->hasMany(Borrow::class);
	}

    public function collection()
    {
        return $this->belongsTo(BookCollection::class, "book_collection_id");
    }

    public function section()
    {
        return $this->belongsTo(BookSection::class, "book_section_id");
    }

    public function stickers()
    {
        $classes = Sticker::getStickerableClasses();

        $stickers = Sticker::whereHasMorph('stickerable', $classes, function (Builder $query) {
            $query->whereHas('books', function(Builder $q)   {
                $q->where('id', $this->id );
            });
        })->when($this->maturita, function($builder) {
            $builder->orWhere('type', 'maturita');
        });

        return $stickers;
    }


    // ATTRIBUTES

    public function getStateAttribute()
	{
        return BookState::make($this)->stringForUser();
	}

	public function getIsReservedAttribute()
	{
		return $this->reservations()->where('reserved_until', '>', now())->exists();
	}

	public function getIsAvailableAttribute()
	{
		return !$this->is_reserved && !$this->is_borrowed;
	}

    public function getIsBorrowedAttribute()
    {
        return $this->borrows()->where('returned', false)->exists();
    }

	public function getCurrentBorrowAttribute()
	{
		return $this->borrows()->where('returned', false)->with('user')->first();
	}

    public function getCurrentReservationAttribute()
	{
		return $this->reservations()->where('reserved_until', '>', now())->with('user')->first();
	}

    public function setIsbnAttribute($value)
    {
        $this->attributes['isbn'] = IsbnNumber::make($value);
    }

    public function getRoutesAttribute()
    {
        return [
            'detail' => route('book.detail', ['id' => $this->id]),
            'admin.detail' => route('admin.book.detail', ['id' => $this->id]),
        ];
    }

    public function __toString()
    {
        return "Kniha: {$this->title}";
    }



}
