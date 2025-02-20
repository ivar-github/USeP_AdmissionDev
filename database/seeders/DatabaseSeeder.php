<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'SDMD',
            'email' => 'ippnaman@usep.edu.ph',
            'type' => 1,
            'status' => 1,
            'password' => '12345678'
        ]);
    }
}
