// resources/views/home.blade.php (Đã sửa đổi)

@extends('layouts.app')

@section('page_title', 'Bảng điều khiển') {{-- Set tiêu đề cho Top Navbar --}}

@section('content')

    {{-- Lời chào mừng --}}
    <div class="mb-4">
        <h3>Chào mừng trở lại, {{ Auth::user()->name }}!</h3>
        <p class="text-muted">Đây là Bảng điều khiển Quản lý Thư viện của bạn.</p>
    </div>

    @if (Auth::user()->isLibrarian())
        
        {{-- Bảng điều khiển của Thủ thư (Librarian Dashboard) --}}
        <div class="row">
            {{-- (Các Card Thống kê ... giữ nguyên code cũ) --}}
            <div class="col-md-4 mb-4"> ... </div>
            <div class="col-md-4 mb-4"> ... </div>
            <div class="col-md-4 mb-4"> ... </div>
        </div>

        <hr class="my-4">

        {{-- Lối tắt Truy cập nhanh --}}
        <h4>Truy cập nhanh</h4>
        <div class="row">
            {{-- (Các Card Truy cập nhanh ... giữ nguyên code cũ) --}}
            <div class="col-md-4 mb-3"> ... </div>
            <div class="col-md-4 mb-3"> ... </div>
            <div class="col-md-4 mb-3"> ... </div>
        </div>

    @else
        
        {{-- Bảng điều khiển của Độc giả (Member Dashboard) --}}
        <div class="card">
            <div class="card-header">{{ __('Bảng điều khiển') }}</div>
            <div class="card-body">
                <p>Chào mừng bạn đến với Thư viện Mini!</p>
            </div>
        </div>

    @endif
            
@endsection

{{-- Xóa CSS tùy chỉnh khỏi file này (vì đã chuyển vào app.scss) --}} 