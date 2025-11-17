<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title', 
        'author', 
        'publication_year', 
        'total_copies', 
        'available_copies'
    ];

    // Mối quan hệ: Một sách có nhiều giao dịch mượn
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }
}