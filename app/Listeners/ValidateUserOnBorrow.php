<?php

namespace App\Listeners;

use App\Events\BookBorrowed;
use App\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ValidateUserOnBorrow
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookBorrowed  $event
     * @return void
     */
    public function handle(BookBorrowed $event)
    {

        $user = $event->borrow->user;
        if($user->role->string === 'registered')
        {
            $user->role()->associate(Role::byString('user'));
            $user->save();
        }
    }
}
