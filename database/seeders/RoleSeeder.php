<?php

// namespace Rras3k\Console\Database\Seeders;

namespace Database\Seeders;



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User
        DB::table('users')->truncate();

        DB::table('users')->insert(
            [
                'name' => 'seb',
                'email' => 'sebastien.net@gmail.com',
                'password' => bcrypt('seb')
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'laurent',
                'email' => 'laurentcarbonnet2a@gmail.com',
                'password' => bcrypt('laurent')
            ]
        );

        // Role
        DB::table('roles')->truncate();
        DB::table('roles')->insert(['nom' => 'root']);
        DB::table('roles')->insert(['nom' => 'admin']);
        DB::table('roles')->insert(['nom' => 'console']);
        DB::table('roles')->insert(['nom' => 'member1']);
        DB::table('roles')->insert(['nom' => 'member2']);
        DB::table('roles')->insert(['nom' => 'member3']);
        DB::table('roles')->insert(['nom' => 'member4']);
        DB::table('roles')->insert(['nom' => 'member5']);


        // role_user
        DB::table('role_user')->truncate();
        DB::table('role_user')->insert(
        ['user_id' => 1, 'role_id' => 1]
        );
        DB::table('role_user')->insert(
        ['user_id' => 1, 'role_id' => 2]
        );
        DB::table('role_user')->insert(
        ['user_id' => 1, 'role_id' => 3]
        );
        DB::table('role_user')->insert(
        ['user_id' => 2, 'role_id' => 2]
        );
        DB::table('role_user')->insert(
        ['user_id' => 2, 'role_id' => 3]
        );
    }
}

