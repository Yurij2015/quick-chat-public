<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $users = User::factory(20)->create([
            'password' => bcrypt('password'),
        ]);

        foreach ($users as $user) {
            $user->assignRole('user');
        }
    }
}
