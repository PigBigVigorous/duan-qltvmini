@extends('layouts.app')

@section('content')
<div class="container">
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
                                {{-- Bạn cần truyền $members từ Controller sang View này --}}
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
                                {{-- Bạn cần truyền $books từ Controller sang View này --}}
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                        {{ $book->title }} (Tồn: {{ $book->available_copies }})
                                    </Doption>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Hạn Trả</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}" required>
                        </div>

                        <a href="{{ route('borrows.index') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Xác Nhận Mượn</Sbutton>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- 
LƯU Ý QUAN TRỌNG:
Để View `borrows/create.blade.php` hoạt động, bạn phải sửa hàm `create()` trong `BorrowController.php` để truyền danh sách Sách (còn tồn kho) và Độc giả sang:

use App\Models\Book;
use App\Models\Member;
// ...
public function create()
{
    $members = Member::orderBy('ten_doc_gia')->get();
    $books = Book::where('available_copies', '>', 0)->orderBy('title')->get();
    return view('borrows.create', compact('members', 'books'));
}
--}}