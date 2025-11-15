<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Book;
use Carbon\Carbon; // Cần dùng Carbon để xử lý ngày tháng

class BorrowController extends Controller
{
    /**
     * INDEX: Hiển thị danh sách các giao dịch đang mượn/quá hạn.
     */
    public function index()
    {
        // Lấy các giao dịch đang mượn ('borrowed')
        // Eager load Book và Member để truy cập tiêu đề sách, tên độc giả
        $borrows = Borrow::with(['book', 'member'])
                         ->where('status', 'borrowed')
                         ->latest('borrow_date')
                         ->paginate(15);
        
        return view('borrows.index', compact('borrows'));
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