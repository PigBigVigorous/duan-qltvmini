<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;   // <<< IMPORT
use App\Models\Member; // <<< IMPORT
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
        // 1. Tạo tài khoản Admin/Thủ thư
        User::factory()->create([
            'name' => 'Thu Thu Admin',
            'email' => 'librarian@thuvien.com',
            'password' => Hash::make('password'),
            'role' => 'librarian',
        ]);
        
        // 2. Tạo tài khoản Độc giả (để test)
        User::factory()->create([
            'name' => 'Doc Gia Test',
            'email' => 'member@thuvien.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // 3. TẠO DỮ LIỆU MẪU (Sử dụng Factories)
        
        // Tạo 50 Sách mẫu
        Book::factory(50)->create();

        // Tạo 100 Độc giả mẫu
        Member::factory(100)->create();

        // (Bạn cũng có thể tạo dữ liệu mượn/trả mẫu ở đây nếu muốn)
    }
}