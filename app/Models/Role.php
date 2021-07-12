<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Return role by string
     * @return Role
     */
    public static function byString($string)
    {
        return Role::where('string', $string)->first();
    }

    public function users()
    {
        $this->hasMany(User::class);
    }

}
