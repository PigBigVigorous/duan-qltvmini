<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrow extends Model
{
    protected $fillable = [
        'member_id', 
        'book_id', 
        'borrow_date', 
        'due_date', 
        'return_date', 
        'status'
    ];
    
    // Mối quan hệ: Giao dịch thuộc về một độc giả
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    // Mối quan hệ: Giao dịch thuộc về một cuốn sách
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}