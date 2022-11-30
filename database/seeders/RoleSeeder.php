<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if( Role::where('role', 'moderator')->doesntExist()) {
            Role::create([
                'role' => 'moderator'
            ]);
            Role::create([
                'role' => 'reader'
            ]);
        }
    }
}
