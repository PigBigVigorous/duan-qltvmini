@extends('layouts.app')

@section('page_title', 'Quản Lý Độc Giả')

@section('content')
    
    <h1>Quản Lý Độc Giả</h1>
    
    {{-- Form Tìm kiếm --}}
    <form action="{{ route('members.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo Tên hoặc Mã độc giả..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Tìm Kiếm</button>
            <a href="{{ route('members.index') }}" class="btn btn-outline-warning">Xóa Tìm</a>
        </div>
    </form>

    <a href="{{ route('members.create') }}" class="btn btn-primary mb-3"><i class="fas fa-user-plus me-1"></i> Thêm Độc Giả Mới</a>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mã Độc Giả</th>
                        <th>Tên Độc Giả</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->ma_doc_gia }}</td>
                            <td>{{ $member->ten_doc_gia }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->dien_thoai }}</td>
                            <td>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
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
                            <td colspan="6" class="text-center">Không tìm thấy độc giả nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($members->hasPages())
            <div class="card-footer">
                {{ $members->links() }}
            </div>
        @endif
    </div>
            
@endsection