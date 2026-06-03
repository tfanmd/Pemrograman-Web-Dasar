<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Jawa Ganteng',
            'email' => 'jawa@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
