<?php

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
            'email'     => "master@czechitas-app.loc",
            'password'  => Hash::make("AppRoot123"),
            'role'      => "master",
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

        DB::table('users')->insert([
            'name'      => "Lišák Admin",
            'email'     => "admin@czechitas-app.loc",
            'password'  => Hash::make("Czechitas123"),
            'role'      => "admin",
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
    }
}
