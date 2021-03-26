<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name'      => "Robin Master",
            'email'     => "da-app.master@czechitas.cz",
            'password'  => Hash::make("AppRoot123"),
            'role'      => "master",
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

        DB::table('users')->insert([
            'name'      => "Lišák Admin",
            'email'     => "da-app.admin@czechitas.cz",
            'password'  => Hash::make("Czechitas123"),
            'role'      => "admin",
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
    }
}
