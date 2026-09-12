<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        // First, seed permissions and roles
        $this->call(PermissionSeeder::class);

        // Create a test user
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'Admin User',
            'email' => 'admin@softghor.com',
            'password' => Hash::make('admin'),
            'is_admin' => 1,
        ]);

        // Assign the admin role to the test user
        $user->assignRole('admin');
        $manager = User::factory()->create([
            'id' => 2,
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
        $manager->assignRole('manager');

        // Optional: Create more users if needed
        // User::factory(10)->create();
    }
}
