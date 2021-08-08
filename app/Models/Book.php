<?php

namespace App\Models;

use App\Models\Content;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use SoftDeletes;

    const TYPE = [
        'Tổng quát',
        'Triết học',
        'Tôn giáo',
        'Khoa học xã hội',
        'Ngôn ngữ',
        'Toán học và khoa học tự nhiên',
        'Kỹ thuật',
        'Nghệ thuật',
        'Văn học',
        'Địa lý lịch sử'
    ];

    protected $fillable = [
        'category',
        'name',
        'auth',
        'publisher',
        'translator',
        'country',
        'quantity',
        'price',
        'year_start',
        'created_by',
        'updated_by',
        'code_isbn'
    ];

    public function content()
    {
        return $this->hasOne(Content::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getName($book_id)
    {
        return DB::table('books')->select('name')->where('id', $book_id)->first()->name;
    }
}
