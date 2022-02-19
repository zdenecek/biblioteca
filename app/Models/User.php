<?php

namespace App\Models;

use App\Casts\SchoolClassCast;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasFactory, Notifiable, SoftDeletes, CanResetPassword;

	protected static function booted()
	{
		static::deleted(function ($user) {
			$user->borrows->each(function ($borrow) {
				$borrow->delete();
			});
			$user->reservations->each(function ($reservation) {
				$reservation->delete();
			});
		});

        static::created(function($user) {
            if( ! $user->code) $user->code = uniqid('u_');
            $user->save();
        });
	}

	protected $appends = [
		'activeBorrows',
	];

	protected $with = [
		'role', 
		'borrows', 
		'reservations',
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
        'school_class',
		'code',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'role_id',
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
        'school_class' => SchoolClassCast::class,
	];

	public function borrows()
	{
		return $this->hasMany(Borrow::class);
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function facilitatedBorrows()
	{
		return $this->hasMany(Borrow::class, 'librarian_id');
	}

	public function hasRole($role)
	{
		return $role->value <= $this->role->value;
	}

	public function getActiveBorrowsAttribute()
	{
		return $this->borrows()->where('returned', false)->count();
	}

    public function getSchoolClassAttribute($value)
    {
        return $value ? new SchoolClass($value) : null;
    }

    public function setSchoolClassAttribute($value)
    {
        $this->attributes['school_class'] = $value ? (new SchoolClass($value))->toYear() : null;
    }

	

	/**
	 * @return bool|string true or reason for failing
	 */
	public function canBorrow(Book $book)
	{
		return $this->borrows->contains(function (Borrow $borrow) {
			return $borrow->isAfterDue();
		}) ?
		'Nelze půjčit, uživatel má výpůjčku s prošlým datem vrácení'
		: true;
	}

	/**
	 * @return bool|string true or reason for failing
	 */
	public function canReserve(Book $book)
	{
		$this->loadCount(['reservations' => function ($query) {
			$query->where('reserved_until', '>', now());
		}]);

        if ( ! $this->hasRole(Role::byString('user'))) {
			return 'Nelze rezervovat, namáte aktivovaný účet, po registraci musíte nejdříve navštívit knihovnu, nebo si o aktivaci zažádat knihovníka přes email';
		}

		if ($this->reservations_count >= 3) {
			return 'Nelze rezervovat, byl dosáhnut maximální počet rezervací';
		}

		if ($this->borrows->contains(function (Borrow $borrow) {
			return $borrow->isAfterDue();
		})) {
			return 'Nelze rezervovat, uživatel má výpůjčku s prošlým datem vrácení';
		}

		return true;
	}
}
