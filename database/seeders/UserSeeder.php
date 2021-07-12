<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertOrIgnore([
            'id' => 1,
            'name' => "Administrátorský účet",
            'email' => config('auth.default_mail'),
            'password' => Hash::make(config('auth.default_password')),
            'code' => 'admin',
            'role_id' => 4,
            'created_at' => now()
        ]);
    }
}
