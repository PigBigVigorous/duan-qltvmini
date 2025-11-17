<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <<< THÊM DÒNG NÀY
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory; // <<< THÊM DÒNG NÀY

    protected $fillable = [
        'title', 
        'author', 
        'publication_year', 
        'total_copies', 
        'available_copies'
    ];

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }
}