@extends('layouts.app')

@section('page_title', 'Quản Lý Sách')

@section('content')
    
    <h1>Quản Lý Sách</h1>
    
    {{-- Form Tìm kiếm (Yêu cầu Đồ án: Tìm) --}}
    <form action="{{ route('books.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo Tiêu đề hoặc Tác giả..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Tìm Kiếm</button>
            <a href="{{ route('books.index') }}" class="btn btn-outline-warning">Xóa Tìm</a>
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
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publication_year }}</td>
                            <td>{{ $book->available_copies }} / {{ $book->total_copies }}</td>
                            <td>
                                {{-- Nút Sửa --}}
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                
                                {{-- Form Xóa --}}
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
                        <tr>
                            <td colspan="6" class="text-center">Không tìm thấy sách nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($books->hasPages())
            <div class="card-footer">
                {{-- Pagination --}}
                {{ $books->links() }}
            </div>
        @endif
    </div>
            
@endsection