<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Settings
{
    public const borrow_time = 'borrow_time';
    public const reservation_time = 'reservation_time';
    public const send_email_on_borrow_expiration = 'send_email_on_borrow_expiration';
    public const contact_librarian = 'contact_librarian';

    public static function get($key)
    {
        return DB::table('settings')->where('key', $key)->value('value');
    }

    public static function set($key, $value)
    {
        return DB::table('settings')->upsert([
            'key' => $key,
            'value' => $value
        ], 'key');
    }

}
