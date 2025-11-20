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
        $query = Book::query();

        // 1. Xử lý Tìm kiếm (Tiêu đề HOẶC Tác giả)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }
        
        // 2. Sắp xếp theo ID tăng dần (1, 2, 3...) như bạn đã yêu cầu trước đó
        // Nếu muốn mới nhất lên đầu thì đổi thành 'desc'
        $books = $query->orderBy('id', 'asc')->paginate(10);

        // Giữ lại tham số tìm kiếm khi chuyển trang (Pagination)
        $books->appends(['search' => $request->search]);

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
        // 1. Validation (Thêm validate cho ảnh)
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'publication_year' => 'required|integer|min:1000|max:'.(date('Y')+1),
            'total_copies' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validate ảnh tối đa 2MB
        ]);
        
        // Lấy tất cả dữ liệu từ form
        $data = $request->all();

        // 2. Xử lý Upload Ảnh
        if ($request->hasFile('image')) {
            // Lấy file từ request
            $file = $request->file('image');
            
            // Đặt tên file duy nhất (timestamp + tên gốc) để tránh trùng
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Di chuyển file vào thư mục public/images/books
            $file->move(public_path('images/books'), $filename);
            
            // Lưu đường dẫn vào mảng dữ liệu
            $data['image'] = 'images/books/' . $filename;
        }

        // 3. Thiết lập tồn kho ban đầu
        $data['available_copies'] = $data['total_copies'];

        // 4. Tạo sách mới
        Book::create($data);
        
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