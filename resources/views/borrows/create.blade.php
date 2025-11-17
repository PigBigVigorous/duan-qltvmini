@extends('layouts.app')

@section('page_title', 'Tạo Phiếu Mượn Sách')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Tạo Phiếu Mượn Sách') }}</div>

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

                <form action="{{ route('borrows.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="member_id" class="form-label">Chọn Độc Giả</label>
                        <select class="form-control" id="member_id" name="member_id" required>
                            <option value="">-- Chọn Độc Giả --</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->ma_doc_gia }} - {{ $member->ten_doc_gia }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="book_id" class="form-label">Chọn Sách (Chỉ sách còn tồn kho)</label>
                        <select class="form-control" id="book_id" name="book_id" required>
                            <option value="">-- Chọn Sách --</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} (Tồn: {{ $book->available_copies }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Hạn Trả</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}" required>
                    </div>

                    <a href="{{ route('borrows.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i> Xác Nhận Mượn</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection