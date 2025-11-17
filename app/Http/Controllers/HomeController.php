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
        $user = Auth::user();
        
        // Dữ liệu cho Thủ thư (Librarian)
        if ($user->isLibrarian()) {
            $statBooks = Book::count();
            $statMembers = Member::count();
            $statBorrows = Borrow::where('status', 'borrowed')->count();
            
            return view('home', compact('statBooks', 'statMembers', 'statBorrows'));
        }
        
        // Dữ liệu cho Độc giả (Member)
        // (Bạn có thể nâng cấp sau này để hiển thị sách họ đang mượn)
        return view('home');
    }
}