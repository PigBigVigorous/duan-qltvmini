<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Member;
use App\Models\Borrow;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var \App\Models\User $user */ // Giúp VS Code nhận diện hàm isLibrarian()
        $user = Auth::user();
        
        // Dữ liệu cho Thủ thư (Librarian)
        if ($user->isLibrarian()) {
            $statBooks = Book::count();
            $statMembers = Member::count();
            $statBorrows = Borrow::where('status', 'borrowed')->count();
            
            return view('home', compact('statBooks', 'statMembers', 'statBorrows'));
        }
        
        // --- DỮ LIỆU CHO ĐỘC GIẢ (MEMBER) ---
        $borrows = null;
        if ($user->member) { // Kiểm tra xem tài khoản User đã được liên kết với hồ sơ Member chưa
            $borrows = $user->member->borrows() // Lấy các giao dịch mượn của member đó
                                  ->with('book') // Lấy kèm thông tin Sách
                                  ->latest('borrow_date') // Sắp xếp mới nhất
                                  ->paginate(10); // Phân trang
        }
        
        return view('home', compact('borrows'));
    }
}