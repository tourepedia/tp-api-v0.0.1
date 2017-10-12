<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Sudhir Mitharwal',
            'email' => 'sudhir.mitharwal@tourepedia.com',
            'password' => app('hash')->make('mitharwal'),
            'remember_token' => str_random(10),
        ]);
    }
}
