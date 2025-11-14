<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Import Model Book

class BookController extends Controller
{
    /**
     * READ: Hiển thị danh sách sách và xử lý tìm kiếm.
     */
    public function index(Request $request)
    {
        // Xử lý Tìm kiếm (Yêu cầu Đồ án)
        $query = Book::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }
        
        $books = $query->latest()->paginate(10);

        return view('books.index', compact('books'));
    }

    /**
     * CREATE: Hiển thị form tạo mới.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * CREATE: Lưu trữ sách mới vào CSDL.
     */
    public function store(Request $request)
    {
        // Yêu cầu Đồ án: An toàn, bảo mật dữ liệu (Validation)
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'total_copies' => 'required|integer|min:1',
            'publication_year' => 'required|digits:4|integer|min:1900|max:'.date('Y'),
        ]);
        
        $book = Book::create($request->all());
        // Thiết lập số lượng tồn kho ban đầu
        $book->available_copies = $book->total_copies; 
        $book->save();
        
        return redirect()->route('books.index')->with('success', 'Thêm sách thành công!');
    }

    /**
     * EDIT: Hiển thị form sửa thông tin sách.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * UPDATE: Cập nhật sách trong CSDL.
     */
    public function update(Request $request, Book $book)
    {
        // Yêu cầu Đồ án: An toàn, bảo mật dữ liệu (Validation)
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'total_copies' => 'required|integer|min:1',
        ]);
        
        $old_total = $book->total_copies;
        $new_total = $request->total_copies;
        
        // Cập nhật số lượng tồn kho dựa trên thay đổi tổng số
        $book->available_copies += ($new_total - $old_total);

        // Đảm bảo số lượng tồn kho không âm
        if ($book->available_copies < 0) {
            return back()->withErrors(['total_copies' => 'Tổng số lượng không thể nhỏ hơn số sách đang được mượn.']);
        }
        
        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Cập nhật sách thành công!');
    }

    /**
     * DELETE: Xóa sách khỏi CSDL.
     */
    public function destroy(Book $book)
    {
        // Kiểm tra sách đang được mượn không
        if ($book->available_copies < $book->total_copies) {
             return back()->withErrors(['error' => 'Không thể xóa sách đang được mượn.']);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Xóa sách thành công!');
    }
}