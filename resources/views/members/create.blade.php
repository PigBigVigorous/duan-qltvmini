@extends('layouts.app')

@section('page_title', 'Thêm Độc Giả Mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Thêm Độc Giả Mới') }}</div>

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

                <form action="{{ route('members.store') }}" method="POST">
                    @csrf
                    
                    {{-- Kiểm tra xem logic tự động tăng mã DG đã được implement chưa --}}
                    @if (View::exists('members.partials.auto_id_info'))
                        <div class="alert alert-info">
                            Mã độc giả sẽ được tự động tạo theo định dạng DG001, DG002...
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="ma_doc_gia" class="form-label">Mã độc giả (VD: DG001)</label>
                            <input type="text" class="form-control" id="ma_doc_gia" name="ma_doc_gia" value="{{ old('ma_doc_gia') }}" required>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="ten_doc_gia" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" id="ten_doc_gia" name="ten_doc_gia" value="{{ old('ten_doc_gia') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="dien_thoai" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="dien_thoai" name="dien_thoai" value="{{ old('dien_thoai') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="{{ old('dia_chi') }}">
                    </div>

                    <a href="{{ route('members.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu Độc Giả</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection