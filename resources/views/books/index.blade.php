@extends('layouts.app')

@section('page_title', 'Quản Lý Sách')

@section('content')
    
    <h1>Quản Lý Sách</h1>
    
    {{-- FORM TÌM KIẾM --}}
    <form action="{{ route('books.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            {{-- Giữ lại từ khóa đã nhập bằng value="{{ request('search') }}" --}}
            <input type="text" name="search" class="form-control" 
                   placeholder="Tìm kiếm theo Tiêu đề hoặc Tác giả..." 
                   value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i> Tìm Kiếm
            </button>
            {{-- Nút Xóa Tìm để quay lại danh sách gốc --}}
            @if(request('search'))
                <a href="{{ route('books.index') }}" class="btn btn-outline-danger">
                    <i class="fas fa-times"></i> Xóa Tìm
                </a>
            @endif
        </div>
    </form>

    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus me-1"></i> Thêm Sách Mới</a>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Năm XB</th>
                        <th>Tồn Kho</th>
                        <th style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- SỬ DỤNG @forelse ĐỂ XỬ LÝ TRƯỜNG HỢP KHÔNG CÓ KẾT QUẢ --}}
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publication_year }}</td>
                            <td>{{ $book->available_copies }} / {{ $book->total_copies }}</td>
                            <td>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- ĐÂY LÀ PHẦN HIỂN THỊ KHI KHÔNG TÌM THẤY SÁCH (Như hình bạn gửi) --}}
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-search mb-2" style="font-size: 2rem;"></i><br>
                                <strong>Không tìm thấy sách nào phù hợp với từ khóa "{{ request('search') }}".</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($books->hasPages())
            <div class="card-footer">
                {{ $books->links() }}
            </div>
        @endif
    </div>
            
@endsection