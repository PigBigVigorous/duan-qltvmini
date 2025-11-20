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
        
        // 1. Xử lý Tìm kiếm (Mã, Tên, Email hoặc Số điện thoại)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('ten_doc_gia', 'like', "%{$search}%")
                  ->orWhere('ma_doc_gia', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('dien_thoai', 'like', "%{$search}%");
            });
        }
        
        // 2. Sắp xếp (Ví dụ: Tên A-Z)
        $members = $query->orderBy('ten_doc_gia', 'asc')->paginate(10);

        // Giữ lại từ khóa tìm kiếm khi qua trang 2, 3...
        $members->appends(['search' => $request->search]);

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
        // 1. Validation (Đã xóa 'ma_doc_gia' khỏi đây)
        $request->validate([
            'ten_doc_gia' => 'required|max:255',
            'dien_thoai' => 'nullable|numeric|digits_between:10,12',
            'email' => 'nullable|email|unique:members',
        ]);
        
        // 2. Tự động tạo 'ma_doc_gia' (DG001, DG002...)
        
        // Lấy độc giả cuối cùng (an toàn nhất là lấy theo ID)
        $lastMember = Member::orderBy('id', 'desc')->first();
        
        $newIdNumber = 1; // ID bắt đầu nếu CSDL rỗng
        
        if ($lastMember && str_starts_with($lastMember->ma_doc_gia, 'DG')) {
            // Nếu đã có độc giả, lấy số cuối cùng và + 1
            $lastIdNumber = (int) substr($lastMember->ma_doc_gia, 2); // Trích xuất số (ví dụ: 'DG005' -> 5)
            $newIdNumber = $lastIdNumber + 1;
        }

        // Định dạng lại ID (ví dụ: 6 -> 'DG006', 123 -> 'DG123')
        $newMaDocGia = 'DG' . str_pad($newIdNumber, 3, '0', STR_PAD_LEFT);

        // 3. Chuẩn bị dữ liệu và tạo mới
        $data = $request->all();
        $data['ma_doc_gia'] = $newMaDocGia;

        Member::create($data);
        
        return redirect()->route('members.index')->with('success', 'Thêm độc giả thành công! Mã mới là: ' . $newMaDocGia);
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