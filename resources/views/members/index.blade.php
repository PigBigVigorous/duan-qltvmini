@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Quản Lý Độc Giả</h1>
            
            {{-- Form Tìm kiếm --}}
            <form action="{{ route('members.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo Tên hoặc Mã độc giả...">
                    <button class="btn btn-outline-secondary" type="submit">Tìm Kiếm</button>
                    <a href="{{ route('members.index') }}" class="btn btn-outline-warning">Xóa Tìm</a>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <a href="{{ route('members.create') }}" class="btn btn-primary mb-3">Thêm Độc Giả Mới</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Độc Giả</th>
                        <th>Tên Độc Giả</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->ma_doc_gia }}</td>
                            <td>{{ $member->ten_doc_gia }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->dien_thoai }}</td>
                            <td>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-info">Sửa</a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection