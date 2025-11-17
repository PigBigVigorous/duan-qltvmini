@extends('layouts.app')

@section('page_title', 'Chỉnh Sửa Sách')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Chỉnh Sửa Sách') }}</div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề sách</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Tác giả</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="publication_year" class="form-label">Năm xuất bản</label>
                            <input type="number" class="form-control" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="total_copies" class="form-label">Tổng số bản</label>
                            <input type="number" class="form-control" id="total_copies" name="total_copies" value="{{ old('total_copies', $book->total_copies) }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="available_copies" class="form-label">Số bản còn lại (Tồn kho)</label>
                        <input type="number" class="form-control" id="available_copies" name="available_copies" value="{{ old('available_copies', $book->available_copies) }}" required>
                        <small class="form-text text-muted">Lưu ý: Logic trong BookController sẽ tự động điều chỉnh tồn kho khi bạn sửa Tổng số bản.</small>
                    </div>

                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Cập Nhật Sách</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection