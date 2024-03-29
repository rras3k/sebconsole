<?php

// namespace Rras3k\Console\Database\Seeders;

namespace Database\Seeders;



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FirstSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // users
        DB::table('users')->truncate();

        DB::table('users')->insert(
            [
                'name' => 'seb',
                'email' => 'sebastien.net@gmail.com',
                'password' => bcrypt('seb')
            ]
        );

        // roles
        DB::table('roles')->truncate();
        DB::table('roles')->insert(['id' => 1, 'nom' => 'root', 'fonction' => 'root']);
        DB::table('roles')->insert(['id' => 2, 'nom' => 'admin', 'fonction' => 'root']);


        // role_user
        DB::table('role_user')->truncate();
        DB::table('role_user')->insert(['user_id' => 1, 'role_id' => 1]);
        DB::table('role_user')->insert(['user_id' => 1, 'role_id' => 2]);

        // log_types
        DB::table('log_types')->truncate();
        DB::table('log_types')->insert(
            ['id' => 1, 'nom' => 'login accepted', 'sys' => true]
        );
    }
}
