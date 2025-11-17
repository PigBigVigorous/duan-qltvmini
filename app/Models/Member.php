<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory; 

    protected $fillable = [
        'ma_doc_gia', 
        'ten_doc_gia', 
        'email', 
        'dien_thoai', 
        'dia_chi'
    ];

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }
}