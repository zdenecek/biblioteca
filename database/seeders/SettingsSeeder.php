<?php

namespace Database\Seeders;

use App\Helpers\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::set(Settings::borrow_time, 30);
        Settings::set(Settings::reservation_time, 14);
        Settings::set(Settings::send_email_on_borrow_expiration, true);
        Settings::set(Settings::contact_librarian, "");
    }
}
