<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // <<< Import Model Book

class WelcomeController extends Controller
{
    /**
     * Hiển thị trang chủ công khai (Landing Page).
     */
    public function index()
    {
        // Lấy 8 cuốn sách mới nhất làm "Sách Nổi Bật"
        $featuredBooks = Book::latest()->take(8)->get();

        // Trả về view 'welcome' và truyền dữ liệu sách
        return view('welcome', compact('featuredBooks'));
    }
}