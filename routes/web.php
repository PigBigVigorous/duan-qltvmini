<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController; // Import mới
use App\Http\Controllers\BorrowController; // Import mới

// Routes Quản lý (Cần bảo vệ bằng Middleware)
Route::resource('books', BookController::class);
Route::resource('members', MemberController::class);

// Route cho nghiệp vụ Mượn/Trả
// Chỉ cần 2 actions: store (mượn) và update (trả)
Route::resource('borrows', BorrowController::class)->only(['index', 'store', 'update']);

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// routes/web.php
Route::middleware(['auth', 'is_librarian'])->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('borrows', BorrowController::class)->only(['index', 'store', 'update']);
    // ... Thêm các route khác của Admin/Thủ thư vào đây
});