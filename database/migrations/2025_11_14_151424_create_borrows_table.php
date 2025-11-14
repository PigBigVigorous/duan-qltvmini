<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('borrows', function (Blueprint $table) {
        $table->id();
        // Khóa ngoại liên kết với Bảng members (độc giả)
        $table->foreignId('member_id')->constrained('members');
        // Khóa ngoại liên kết với Bảng books (sách)
        $table->foreignId('book_id')->constrained('books');
        
        $table->date('borrow_date'); // Ngày mượn
        $table->date('due_date');    // Ngày trả dự kiến
        $table->date('return_date')->nullable(); // Ngày trả thực tế
        $table->string('status', 50)->default('borrowed'); // 'borrowed' hoặc 'returned'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
