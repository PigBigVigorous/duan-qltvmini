@extends('layouts.app')

{{-- Thêm một chút CSS tùy chỉnh cho Dashboard Cards --}}
@push('styles')
<style>
    .dashboard-card {
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .card-icon {
        font-size: 3rem;
        opacity: 0.3;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            {{-- Lời chào mừng --}}
            <div class="mb-4">
                <h3>Chào mừng trở lại, {{ Auth::user()->name }}!</h3>
                <p class="text-muted">Đây là Bảng điều khiển Quản lý Thư viện của bạn.</p>
            </div>

            {{-- Kiểm tra vai trò để hiển thị nội dung tương ứng --}}
            @if (Auth::user()->isLibrarian())
                
                {{-- Bảng điều khiển của Thủ thư (Librarian Dashboard) --}}
                <div class="row">
                    
                    {{-- Card Thống kê 1: Tổng số Sách --}}
                    <div class="col-md-4 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body position-relative">
                                <h5 class="card-title">TỔNG SỐ SÁCH</h5>
                                <h2 class="display-4">{{ $statBooks ?? 0 }}</h2>
                                <i class="fas fa-book card-icon"></i> {{-- (Cần Font Awesome) --}}
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

                {{-- Lối tắt Truy cập nhanh --}}
                <h4>Truy cập nhanh</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('books.index') }}" class="dashboard-card card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Quản Lý Sách</h5>
                                <p class="card-text text-muted">Thêm, sửa, xóa và tìm kiếm sách.</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('members.index') }}" class="dashboard-card card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Quản Lý Độc Giả</h5>
                                <p class="card-text text-muted">Quản lý thông tin thành viên thư viện.</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('borrows.index') }}" class="dashboard-card card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Quản Lý Mượn/Trả</h5>
                                <p class="card-text text-muted">Xem các phiếu mượn và đánh dấu trả sách.</p>
                            </div>
                        </a>
                    </div>
                </div>

            @else
                
                {{-- Bảng điều khiển của Độc giả (Member Dashboard) --}}
                <div class="card">
                    <div class="card-header">{{ __('Bảng điều khiển') }}</div>
                    <div class="card-body">
                        <p>Chào mừng bạn đến với Thư viện Mini!</p>
                        <p>Bạn có thể sử dụng thanh tìm kiếm (chúng ta sẽ thêm sau) để tìm sách.</p>
                        {{-- Nâng cấp sau này: Hiển thị sách đang mượn của độc giả tại đây --}}
                    </div>
                </div>

            @endif
            
        </div>
    </div>
</div>
@endsection

{{-- 
Lưu ý: 
- Các icon (biểu tượng) như <i class="fas fa-book"></i> yêu cầu bạn phải cài đặt Font Awesome. 
- Nếu bạn không muốn cài, hãy xóa các dòng <i class="..."></i> đi, giao diện vẫn hoạt động bình thường. 
--}}