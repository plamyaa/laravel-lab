<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name'=>'mikhail',
            'email'=>'sergeevm100@gmail.com',
            'password'=> Hash::make('123456'),
            'role_id' => 1,
        ]);
        \App\Models\User::create([
            'name'=>'olga',
            'email' => 'e@mail.ru',
            'password' => Hash::make('123456'),
            'role_id' => 2,
        ]);
    }
}
