@extends('layouts.app') 
{{-- Kế thừa layout Bootstrap cơ bản --}}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Quản Lý Sách</h1>
            
            {{-- Form Tìm kiếm (Yêu cầu Đồ án: Tìm) --}}
            <form action="{{ route('books.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo Tiêu đề hoặc Tác giả...">
                    <button class="btn btn-outline-secondary" type="submit">Tìm Kiếm</button>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-warning">Xóa Tìm</a>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Thêm Sách Mới</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Năm XB</th>
                        <th>Tồn Kho</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publication_year }}</td>
                            <td>{{ $book->available_copies }} / {{ $book->total_copies }}</td>
                            <td>
                                {{-- Nút Sửa --}}
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-info">Sửa</a>
                                
                                {{-- Form Xóa --}}
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Pagination --}}
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection