@extends('layouts.app')

@section('page_title', 'Quản Lý Mượn Trả')

@section('content')
    
    <h1>Quản Lý Mượn Trả Sách</h1>

    {{-- FORM TÌM KIẾM --}}
    <form action="{{ route('borrows.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" 
                   placeholder="Nhập Tên Sách hoặc Tên Độc Giả..." 
                   value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i> Tìm Kiếm
            </button>
            @if(request('search'))
                <a href="{{ route('borrows.index') }}" class="btn btn-outline-danger">
                    <i class="fas fa-times"></i> Xóa Tìm
                </a>
            @endif
        </div>
    </form>

    <a href="{{ route('borrows.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus me-1"></i> Tạo Phiếu Mượn Mới</a>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên Sách</th>
                        <th>Tên Độc Giả</th>
                        <th>Ngày Mượn</th>
                        <th>Hạn Trả</th>
                        <th>Trạng thái</th>
                        <th style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrows as $borrow)
                        <tr class="{{ $borrow->due_date < now()->toDateString() && $borrow->status == 'borrowed' ? 'table-danger' : '' }}">
                            <td>{{ $borrow->id }}</td>
                            <td>{{ $borrow->book->title ?? 'N/A' }}</td>
                            <td>{{ $borrow->member->ten_doc_gia ?? 'N/A' }}</td>
                            <td>{{ $borrow->borrow_date }}</td>
                            <td>{{ $borrow->due_date }}</td>
                            <td>
                                @if ($borrow->status == 'returned')
                                    <span class="badge bg-success">Đã Trả</span>
                                @elseif ($borrow->due_date < now()->toDateString())
                                    <span class="badge bg-danger">Quá Hạn</span>
                                @else
                                    <span class="badge bg-warning text-dark">Đang Mượn</span>
                                @endif
                            </td>
                            <td>
                                @if ($borrow->status == 'borrowed')
                                    <form action="{{ route('borrows.update', $borrow->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-undo-alt me-1"></i> Đã Trả
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- THÔNG BÁO KHÔNG TÌM THẤY --}}
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-search mb-2" style="font-size: 2rem;"></i><br>
                                <strong>Không tìm thấy phiếu mượn nào phù hợp với từ khóa "{{ request('search') }}".</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($borrows->hasPages())
            <div class="card-footer">
                {{ $borrows->links() }}
            </div>
        @endif
    </div>
            
@endsection