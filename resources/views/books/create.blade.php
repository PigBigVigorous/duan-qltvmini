@extends('layouts.app')

@section('page_title', 'Thêm Sách Mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Thêm Sách Mới') }}</div>
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
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề sách</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Tác giả</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="publication_year" class="form-label">Năm xuất bản</label>
                            <input type="number" class="form-control" id="publication_year" name="publication_year" value="{{ old('publication_year') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="total_copies" class="form-label">Tổng số bản</label>
                            <input type="number" class="form-control" id="total_copies" name="total_copies" value="{{ old('total_copies') }}" required>
                        </div>
                    </div>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu Sách</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection