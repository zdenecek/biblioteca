<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'value' => 0, 'string' => 'registered', 'name' => 'Uživatel (neaktivovaný)'],
            ['id' => 2, 'value' => 1, 'string' => 'user', 'name' => 'Uživatel'],
            ['id' => 3, 'value' => 2, 'string' => 'librarian', 'name' => 'Knihovník'],
            ['id' => 4, 'value' => 4, 'string' => 'admin', 'name' => 'Administrátor'],
        ]);
    }
}
