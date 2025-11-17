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
    private function seedRealMembers(): void
    {
        $members = [
            [
                'ten' => 'Nguyễn Văn An', 
                'email' => 'an.nguyen@example.com', 
                'phone' => '0905111222', 
                'address' => 'Q.1, TP.HCM'
            ],
            [
                'ten' => 'Trần Thị Bình', 
                'email' => 'binh.tran@example.com', 
                'phone' => '0913222333', 
                'address' => 'Q. Hai Bà Trưng, Hà Nội'
            ],
            [
                'ten' => 'Lê Văn Cường', 
                'email' => 'cuong.le@example.com', 
                'phone' => '0989444555', 
                'address' => 'Q. Sơn Trà, Đà Nẵng'
            ],
            [
                'ten' => 'Phạm Thị Dung', 
                'email' => 'dung.pham@example.com', 
                'phone' => '0977666777', 
                'address' => 'Q. Ninh Kiều, Cần Thơ'
            ],
            [
                'ten' => 'Võ Minh Hải', 
                'email' => 'hai.vo@example.com', 
                'phone' => '0935888999', 
                'address' => 'TP. Long Xuyên, An Giang'
            ],
        ];

        $idCounter = 1; // Biến đếm bắt đầu từ 1

        foreach ($members as $memberData) {
            
            // Tạo mã DG001, DG002...
            $maDocGia = 'DG' . str_pad($idCounter, 3, '0', STR_PAD_LEFT);

            Member::create([
                'ma_doc_gia' => $maDocGia, // Sử dụng mã tự tăng
                'ten_doc_gia' => $memberData['ten'],
                'email' => $memberData['email'],
                'dien_thoai' => $memberData['phone'],
                'dia_chi' => $memberData['address'],
            ]);
            
            $idCounter++; // Tăng biến đếm
        }
    }
}