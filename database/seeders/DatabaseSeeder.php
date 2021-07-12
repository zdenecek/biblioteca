<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookSection;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingsSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            BookCollectionSeeder::class,
            BookSectionSeeder::class
        ]);
    }
}
