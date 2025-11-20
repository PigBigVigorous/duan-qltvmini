<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Book;
use Carbon\Carbon; // Cần dùng Carbon để xử lý ngày tháng
use App\Models\Member;
class BorrowController extends Controller
{
    /**
     * INDEX: Hiển thị danh sách các giao dịch đang mượn/quá hạn.
     */
    public function index(Request $request)
    {
        // Khởi tạo query, Eager Load quan hệ để tránh N+1 Query
        $query = Borrow::with(['book', 'member']);

        // 1. Xử lý Tìm kiếm Nâng cao (Tìm theo Tên Sách HOẶC Tên Độc Giả)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                // Tìm trong bảng Books
                $q->whereHas('book', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })
                // HOẶC tìm trong bảng Members
                ->orWhereHas('member', function($q) use ($search) {
                    $q->where('ten_doc_gia', 'like', "%{$search}%")
                      ->orWhere('ma_doc_gia', 'like', "%{$search}%");
                });
            });
        }

        // Lọc trạng thái (Mặc định chỉ hiện sách đang mượn, trừ khi tìm kiếm)
        // Nếu bạn muốn tìm trong CẢ lịch sử trả sách thì bỏ dòng where('status') đi
        // $query->where('status', 'borrowed'); 
        
        $borrows = $query->latest('borrow_date')->paginate(15);
        
        $borrows->appends(['search' => $request->search]);

        return view('borrows.index', compact('borrows'));
    }

    public function create()
    {
        // Lấy danh sách độc giả
        $members = Member::orderBy('ten_doc_gia')->get();
        
        // Lấy danh sách sách còn tồn kho (available > 0)
        $books = Book::where('available_copies', '>', 0)->orderBy('title')->get();
        
        // Trả về view và truyền 2 biến này sang
        return view('borrows.create', compact('members', 'books'));
    }

    /**
     * STORE (MƯỢN SÁCH): Xử lý việc tạo mới giao dịch mượn.
     */
    public function store(Request $request)
    {
        // 1. Validation (An toàn & Bảo mật)
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'due_date' => 'required|date|after:today', // Yêu cầu ngày trả sau ngày hôm nay
        ]);
        
        // 2. Kiểm tra tồn kho
        $book = Book::find($request->book_id);
        if ($book->available_copies <= 0) {
            return back()->withErrors(['book_id' => 'Sách này đã hết bản có sẵn để mượn.'])
                         ->withInput();
        }
        
        // 3. Tạo giao dịch mượn
        Borrow::create([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'borrow_date' => Carbon::now()->toDateString(),
            'due_date' => $request->due_date,
            'status' => 'borrowed',
        ]);
        
        // 4. Cập nhật tồn kho (Giảm số lượng)
        $book->available_copies -= 1;
        $book->save();

        return redirect()->route('borrows.index')->with('success', 'Mượn sách thành công! Đã cập nhật tồn kho.');
    }

    /**
     * UPDATE (TRẢ SÁCH): Xử lý việc cập nhật trạng thái trả sách.
     */
    public function update(Request $request, Borrow $borrow)
    {
        // 1. Kiểm tra trạng thái hiện tại
        if ($borrow->status !== 'borrowed') {
            return back()->withErrors(['error' => 'Giao dịch này đã được trả hoặc không hợp lệ.']);
        }
        
        // 2. Cập nhật giao dịch (Trả sách)
        $borrow->update([
            'return_date' => Carbon::now()->toDateString(),
            'status' => 'returned',
        ]);
        
        // 3. Cập nhật tồn kho (Tăng số lượng)
        $book = $borrow->book; // Lấy sách thông qua Relationship
        $book->available_copies += 1;
        $book->save();

        return redirect()->route('borrows.index')->with('success', 'Trả sách thành công! Đã cập nhật tồn kho.');
    }
    
    // Hàm create, show, edit, destroy thường không được dùng trong nghiệp vụ Borrow.
}