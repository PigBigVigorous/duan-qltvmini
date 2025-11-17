@extends('layouts.app')

{{-- Đặt tiêu đề cho Top Navbar --}}
@section('page_title', 'Bảng điều khiển')

@section('content')

    {{-- Lời chào mừng --}}
    <div class="mb-4">
        <h3>Chào mừng trở lại, {{ Auth::user()->name }}!</h3>
    </div>

    {{-- KIỂM TRA VAI TRÒ --}}
    @if (Auth::user()->isLibrarian())
        
        {{-- =================================================== --}}
        {{-- 1. GIAO DIỆN CỦA THỦ THƯ (LIBRARIAN) --}}
        {{-- =================================================== --}}
        
        <p class="text-muted">Đây là Bảng điều khiển Quản lý Thư viện của bạn.</p>
        <div class="row">
            {{-- Card Thống kê 1: Tổng số Sách --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body position-relative">
                        <h5 class="card-title">TỔNG SỐ SÁCH</h5>
                        <h2 class="display-4">{{ $statBooks ?? 0 }}</h2>
                        <i class="fas fa-book card-icon"></i>
                    </div>
                </div>
            </div>

            {{-- Card Thống kê 2: Tổng số Độc giả --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body position-relative">
                        <h5 class="card-title">TỔNG SỐ ĐỘC GIẢ</h5>
                        <h2 class="display-4">{{ $statMembers ?? 0 }}</h2>
                        <i class="fas fa-users card-icon"></i>
                    </div>
                </div>
            </div>

            {{-- Card Thống kê 3: Sách đang mượn --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-warning text-dark h-100">
                    <div class="card-body position-relative">
                        <h5 class="card-title">SÁCH ĐANG MƯỢN</h5>
                        <h2 class="display-4">{{ $statBorrows ?? 0 }}</h2>
                        <i class="fas fa-clipboard-list card-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">
        {{-- (Phần Lối tắt Truy cập nhanh của Thủ thư giữ nguyên) --}}
        <h4>Truy cập nhanh</h4>
        <div class="row"> ... </div>

    @else
        
        {{-- =================================================== --}}
        {{-- 2. GIAO DIỆN CỦA ĐỘC GIẢ (MEMBER) --}}
        {{-- =================================================== --}}

        <p class="text-muted">Đây là lịch sử mượn sách của bạn tại thư viện.</p>
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history me-1"></i>
                Lịch Sử Mượn Sách Của Tôi
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Tên Sách</th>
                            <th>Ngày Mượn</th>
                            <th>Hạn Trả</th>
                            <th>Ngày Trả Thực Tế</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Kiểm tra xem biến $borrows có tồn tại và có dữ liệu không --}}
                        @if (isset($borrows) && $borrows->count() > 0)
                            @foreach ($borrows as $borrow)
                                <tr class="{{ $borrow->due_date < now()->toDateString() && $borrow->status == 'borrowed' ? 'table-danger' : '' }}">
                                    <td>{{ $borrow->book->title ?? 'Sách không còn tồn tại' }}</td>
                                    <td>{{ $borrow->borrow_date }}</td>
                                    <td>{{ $borrow->due_date }}</td>
                                    <td>{{ $borrow->return_date ?? 'Chưa trả' }}</td>
                                    <td>
                                        @if ($borrow->status == 'returned')
                                            <span class="badge bg-success">Đã Trả</span>
                                        @elseif ($borrow->due_date < now()->toDateString())
                                            <span class="badge bg-danger">Quá Hạn</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Đang Mượn</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- Xử lý nếu $borrows rỗng hoặc tài khoản chưa liên kết --}}
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    @if (!Auth::user()->member)
                                        Tài khoản của bạn chưa được liên kết với hồ sơ độc giả.
                                    @else
                                        Bạn chưa mượn cuốn sách nào.
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if (isset($borrows) && $borrows->hasPages())
                <div class="card-footer">
                    {{ $borrows->links() }}
                </div>
            @endif
        </div>

    @endif
            
@endsection