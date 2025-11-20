<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

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

        // 2. TẠO DỮ LIỆU SÁCH THẬT (ĐÃ CÓ URL ẢNH)
        $this->seedRealBooks();

        // 3. TẠO ĐỘC GiẢ THẬT
        $this->seedRealMembers();
    }

    /**
     * Hàm riêng để tạo sách thật (ĐÃ CÓ HÌNH ẢNH)
     */
    private function seedRealBooks(): void
    {
        $books = [
            [
                'title' => 'Dế Mèn Phiêu Lưu Ký', 
                'author' => 'Tô Hoài', 
                'year' => 1941, 
                'copies' => 15,
                // Lưu đường dẫn tương đối tính từ thư mục public
                'image' => 'images/books/DeMenPhieuLuuKy.jpg' 
            ],
            [
                'title' => 'Số Đỏ', 
                'author' => 'Vũ Trọng Phụng', 
                'year' => 1936, 
                'copies' => 10,
                'image' => 'images/books/SoDo.jpg'
            ],
            [
                'title' => 'Lão Hạc', 
                'author' => 'Nam Cao', 
                'year' => 1943, 
                'copies' => 20,
                'image' => 'images/books/LaoHac.jpg'
            ],
            [
                'title' => 'Mắt Biếc', 
                'author' => 'Nguyễn Nhật Ánh', 
                'year' => 1990, 
                'copies' => 25,
                'image' => 'images/books/MatBiec.jpg'
            ],
            [
                'title' => 'Nhà Giả Kim', 
                'author' => 'Paulo Coelho', 
                'year' => 1988, 
                'copies' => 10,
                'image' => 'images/books/NhaGiaKim.jpg'
            ],
            [
                'title' => 'Đắc Nhân Tâm', 
                'author' => 'Dale Carnegie', 
                'year' => 1936, 
                'copies' => 20,
                'image' => 'images/books/DacNhanTam.jpg'
            ],
        ];

        foreach ($books as $bookData) {
            Book::create([
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'publication_year' => $bookData['year'],
                'image' => $bookData['image'], // <<< CẬP NHẬT
                'total_copies' => $bookData['copies'],
                'available_copies' => $bookData['copies'],
            ]);
        }
    }

    /**
     * Hàm tạo độc giả thật (Việt Nam)
     */
    private function seedRealMembers(): void
    {
        $members = [
            ['ten' => 'Nguyễn Văn An', 'email' => 'an.nguyen@example.com', 'phone' => '0905111222', 'address' => 'Q.1, TP.HCM'],
            ['ten' => 'Trần Thị Bình', 'email' => 'binh.tran@example.com', 'phone' => '0913222333', 'address' => 'Q. Hai Bà Trưng, Hà Nội'],
            ['ten' => 'Lê Văn Cường', 'email' => 'cuong.le@example.com', 'phone' => '0989444555', 'address' => 'Q. Sơn Trà, Đà Nẵng'],
        ];
        
        $idCounter = 1;
        foreach ($members as $memberData) {
            $maDocGia = 'DG' . str_pad($idCounter, 3, '0', STR_PAD_LEFT);
            Member::create([
                'ma_doc_gia' => $maDocGia,
                'ten_doc_gia' => $memberData['ten'],
                'email' => $memberData['email'],
                'dien_thoai' => $memberData['phone'],
                'dia_chi' => $memberData['address'],
            ]);
            $idCounter++;
        }
    }
}