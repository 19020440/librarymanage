<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_CONFIRM = 1;
    const STATUS_OVERDUE = 2;
    const STATUS_BORROWING = 3;
    const STATUS_BORROWED = 4;
    const STATUS_CANCEL = 5;

    const PHONE_DEFAULT = '0123456789';

    protected $fillable = [
        'user_id',
        'time_borrow',
        'time_promise_pay',
        'time_pay',
        'status',
        'address',
        'note'
    ];

    public function orderdetails()
    {
        return $this->hasMany(Orderdetail::class);
    }
}
