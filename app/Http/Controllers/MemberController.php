<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Import Model Member

class MemberController extends Controller
{
    /**
     * 1. INDEX (READ): Hiển thị danh sách độc giả và xử lý tìm kiếm.
     */
    public function index(Request $request)
    {
        $query = Member::query();
        
        // Xử lý Tìm kiếm (Yêu cầu Đồ án: Tìm kiếm)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ten_doc_gia', 'like', "%{$search}%")
                  ->orWhere('ma_doc_gia', 'like', "%{$search}%");
        }
        
        $members = $query->latest()->paginate(10);

        // Trả về View với dữ liệu độc giả
        return view('members.index', compact('members'));
    }

    /**
     * 2. CREATE: Hiển thị form tạo độc giả mới.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * 3. STORE (CREATE): Lưu độc giả mới vào CSDL.
     */
    public function store(Request $request)
    {
        // Yêu cầu Đồ án: An toàn, bảo mật dữ liệu (Validation)
        $request->validate([
            'ma_doc_gia' => 'required|unique:members|max:50',
            'ten_doc_gia' => 'required|max:255',
            'dien_thoai' => 'nullable|numeric|digits_between:10,12',
            'email' => 'nullable|email|unique:members',
        ]);
        
        Member::create($request->all());
        
        return redirect()->route('members.index')->with('success', 'Thêm độc giả thành công!');
    }

    /**
     * 4. SHOW (READ): Hiển thị chi tiết độc giả (Thường dùng cho việc xem lịch sử mượn).
     */
    public function show(Member $member)
    {
        // Bạn có thể dùng hàm này để hiển thị lịch sử mượn/trả của độc giả.
        // Ví dụ: $borrows = $member->borrows()->latest()->get();
        return view('members.show', compact('member'));
    }

    /**
     * 5. EDIT: Hiển thị form sửa thông tin độc giả.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * 6. UPDATE (UPDATE): Cập nhật độc giả trong CSDL.
     */
    public function update(Request $request, Member $member)
    {
        // Yêu cầu Đồ án: An toàn, bảo mật dữ liệu (Validation)
        $request->validate([
            // Bỏ qua mã độc giả hiện tại khi kiểm tra unique
            'ma_doc_gia' => 'required|max:50|unique:members,ma_doc_gia,' . $member->id, 
            'ten_doc_gia' => 'required|max:255',
            'dien_thoai' => 'nullable|numeric|digits_between:10,12',
            // Bỏ qua email hiện tại khi kiểm tra unique
            'email' => 'nullable|email|unique:members,email,' . $member->id,
        ]);
        
        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Cập nhật độc giả thành công!');
    }

    /**
     * 7. DESTROY (DELETE): Xóa độc giả khỏi CSDL.
     */
    public function destroy(Member $member)
    {
        // Kiểm tra logic quan trọng: Độc giả còn đang mượn sách không.
        // Giả sử Model Member có mối quan hệ hasMany với Borrow.
        // if ($member->borrows()->where('status', 'borrowed')->exists()) {
        //      return back()->withErrors(['error' => 'Không thể xóa độc giả này vì họ còn đang mượn sách.']);
        // }

        $member->delete();
        return redirect()->route('members.index')->with('success', 'Xóa độc giả thành công!');
    }
}