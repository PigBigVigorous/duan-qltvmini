@extends('layouts.app')

@section('page_title', 'Chỉnh Sửa Độc Giả')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Chỉnh Sửa Độc Giả') }}</div>

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

                <form action="{{ route('members.update', $member->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="ma_doc_gia" class="form-label">Mã độc giả</label>
                        <input type="text" class="form-control" id="ma_doc_gia" name="ma_doc_gia" value="{{ old('ma_doc_gia', $member->ma_doc_gia) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ten_doc_gia" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" id="ten_doc_gia" name="ten_doc_gia" value="{{ old('ten_doc_gia', $member->ten_doc_gia) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $member->email) }}">
                    </div>

                    <div class="mb-3">
                        <label for="dien_thoai" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="dien_thoai" name="dien_thoai" value="{{ old('dien_thoai', $member->dien_thoai) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="{{ old('dia_chi', $member->dia_chi) }}">
                    </div>

                    <a href="{{ route('members.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Cập Nhật Độc Giả</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection