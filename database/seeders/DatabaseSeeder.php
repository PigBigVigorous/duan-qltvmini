<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo tài khoản Admin/Thủ thư (Vai trò: librarian)
        User::factory()->create([
            'name' => 'Thu Thu Admin',
            'email' => 'librarian@thuvien.com',
            'password' => Hash::make('password'), // Dùng Hash::make() sau khi đã import
            'role' => 'librarian',
        ]);
        
        // 2. Tạo tài khoản độc giả (Vai trò: member)
        User::factory()->create([
            'name' => 'Doc Gia Test',
            'email' => 'member@thuvien.com',
            'password' => Hash::make('password'), // Dùng Hash::make() sau khi đã import
            'role' => 'member',
        ]);

    }


}