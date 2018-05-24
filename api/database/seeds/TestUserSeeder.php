<?php

use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
          'name' => str_random(10),
          'username' => 'test_' . str_random(2),
          'password' => app('hash')->make('secret'),
      ]);
    }
}
