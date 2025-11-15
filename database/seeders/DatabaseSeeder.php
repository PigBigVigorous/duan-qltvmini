<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Doc Gia Test',
            'email' => 'member@thuvien.com',
            'password' => Hash::make('password'), // Mật khẩu là 'password'
            'role' => 'member',
        ]);

        User::factory()->create([
            'name' => 'Thu Thu Admin',
            'email' => 'librarian@thuvien.com',
            'password' => Hash::make('password'), // Mật khẩu là 'password'
            'role' => 'librarian',
        ]);
    }
}
