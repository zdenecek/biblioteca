<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookCollection extends Model
{
	use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $table = "book_collections";

	protected $fillable = [
		'name',
    ];

	public function books()
	{
		return $this->hasMany(Book::class, "book_collection_id");
	}

    public function stickers()
    {
        return $this->morphToMany(Sticker::class, 'sticker');
    }

    public function __toString()
    {
        return "Sbírka: {$this->name}";
    }
}
