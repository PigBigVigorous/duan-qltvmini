<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Các route của Auth (Login, Register...)
Auth::routes();

// Trang chủ sau khi đăng nhập (chung cho mọi vai trò)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Nhóm Routes Quản lý (Chỉ Thủ thư/Admin mới được vào)
// Đã sửa 'is_librarian' thành 'role:librarian'
Route::middleware(['auth', 'role:librarian'])->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('borrows', BorrowController::class)->only(['index', 'store', 'update', 'create']);
    // (Lưu ý: tôi đã thêm 'create' vào borrows.class để Form Mượn Sách hoạt động)
});