<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImport extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function books() {
        return $this->hasMany(Book::class);
    }
}
