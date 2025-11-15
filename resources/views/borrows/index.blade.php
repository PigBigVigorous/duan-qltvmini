@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Quản Lý Mượn Trả Sách (Sách đang mượn)</h1>
            
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('borrows.create') }}" class="btn btn-primary mb-3">Tạo Phiếu Mượn Mới</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sách</th>
                        <th>Tên Độc Giả</th>
                        <th>Ngày Mượn</th>
                        <th>Hạn Trả</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrows as $borrow)
                        <tr class="{{ $borrow->due_date < now() ? 'table-danger' : '' }}">
                            <td>{{ $borrow->id }}</td>
                            <td>{{ $borrow->book->title ?? 'N/A' }}</td>
                            <td>{{ $borrow->member->ten_doc_gia ?? 'N/A' }}</td>
                            <td>{{ $borrow->borrow_date }}</td>
                            <td>{{ $borrow->due_date }}</td>
                            <td>
                                @if ($borrow->due_date < now())
                                    <span class="badge bg-danger">Quá Hạn</span>
                                @else
                                    <span class="badge bg-warning">Đang Mượn</span>
                                @endif
                            </td>
                            <td>
                                {{-- Form Trả Sách --}}
                                <form action="{{ route('borrows.update', $borrow->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">Đánh Dấu Đã Trả</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Không có sách nào đang được mượn.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{ $borrows->links() }}
        </div>
    </div>
</div>
@endsection