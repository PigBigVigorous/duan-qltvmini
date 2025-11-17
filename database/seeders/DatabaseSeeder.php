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
        // 1. Tạo tài khoản
        User::factory()->create([
            'name' => 'Thu Thu Admin',
            'email' => 'librarian@thuvien.com',
            'password' => Hash::make('password'),
            'role' => 'librarian',
        ]);
        User::factory()->create([
            'name' => 'Doc Gia Test',
            'email' => 'member@thuvien.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // 2. TẠO DỮ LIỆU SÁCH THẬT (VIỆT NAM VÀ NƯỚC NGOÀI)
        $this->seedRealBooks();

        // 3. TẠO ĐỘC GiẢ MẪU (BẰNG TIẾNG VIỆT)
        // (Sau khi đổi faker_locale, Factory này sẽ tạo tên Tiếng Việt)
        Member::factory(100)->create();
    }

    /**
     * Hàm riêng để tạo sách thật
     */
    private function seedRealBooks(): void
    {
        $books = [
            // Tác phẩm Việt Nam
            ['title' => 'Dế Mèn Phiêu Lưu Ký', 'author' => 'Tô Hoài', 'year' => 1941, 'copies' => 15],
            ['title' => 'Số Đỏ', 'author' => 'Vũ Trọng Phụng', 'year' => 1936, 'copies' => 10],
            ['title' => 'Lão Hạc', 'author' => 'Nam Cao', 'year' => 1943, 'copies' => 20],
            ['title' => 'Tắt Đèn', 'author' => 'Ngô Tất Tố', 'year' => 1937, 'copies' => 12],
            ['title' => 'Truyện Kiều', 'author' => 'Nguyễn Du', 'year' => 1820, 'copies' => 5],
            ['title' => 'Đất Rừng Phương Nam', 'author' => 'Đoàn Giỏi', 'year' => 1957, 'copies' => 18],
            ['title' => 'Mắt Biếc', 'author' => 'Nguyễn Nhật Ánh', 'year' => 1990, 'copies' => 25],
            ['title' => 'Cho Tôi Xin Một Vé Đi Tuổi Thơ', 'author' => 'Nguyễn Nhật Ánh', 'year' => 2008, 'copies' => 30],
            
            // Tác phẩm Nước ngoài
            ['title' => 'Harry Potter và Hòn Đá Phù Thủy', 'author' => 'J. K. Rowling', 'year' => 1997, 'copies' => 15],
            ['title' => 'Nhà Giả Kim', 'author' => 'Paulo Coelho', 'year' => 1988, 'copies' => 10],
            ['title' => 'Đắc Nhân Tâm', 'author' => 'Dale Carnegie', 'year' => 1936, 'copies' => 20],
            ['title' => 'Hoàng Tử Bé', 'author' => 'Antoine de Saint-Exupéry', 'year' => 1943, 'copies' => 15],
        ];

        foreach ($books as $bookData) {
            Book::create([
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'publication_year' => $bookData['year'],
                'total_copies' => $bookData['copies'],
                'available_copies' => $bookData['copies'], // Ban đầu tồn kho = tổng số
            ]);
        }
    }
}