<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookSection extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function stickers()
    {
        return $this->morphToMany(Sticker::class, 'sticker');
    }

    public function books(){
        return $this->hasMany(Book::class, 'book_section_id');
    }

    public function __toString()
    {
        return "Sekce: {$this->name}";
    }
}
