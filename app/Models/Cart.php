<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}
