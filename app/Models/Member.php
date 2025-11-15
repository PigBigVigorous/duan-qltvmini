<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'ma_doc_gia', 'ten_doc_gia', 'email', 'dien_thoai', 'dia_chi'
    ];

    // Mối quan hệ: Một độc giả có nhiều giao dịch mượn
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }
}