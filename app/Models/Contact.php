<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    const STATUS_NOT_READ = 0;
    const STATUS_READED = 1;

    protected $fillable = [
        'name',
        'email',
        'title',
        'message',
        'is_readed'
    ];
}
