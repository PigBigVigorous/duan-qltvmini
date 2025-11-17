@extends('layouts.app')

@section('page_title', 'Quản Lý Mượn Trả')

@section('content')
    
    <h1>Quản Lý Mượn Trả Sách (Sách đang mượn)</h1>

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
                        {{-- Tô màu đỏ nếu quá hạn --}}
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
                                {{-- Chỉ hiển thị nút Trả nếu sách đang mượn --}}
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
                        <tr>
                            <td colspan="7" class="text-center">Không có sách nào đang được mượn.</td>
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