<?php

namespace App\Repositories\Cart;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected $perPage = 20;

    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Cart::class;
    }

    public function getCartByUserAndBook($bookId, $userId)
    {
        return $this->model->where('book_id', $bookId)->where('user_id', $userId)->first();
    }

    public function getTotalBookOfUser($userId)
    {
        return $this->model->selectRaw('sum(quantity) as sum')->where('user_id', $userId)->first()->sum;
    }

    public function deleteAllCart($userId)
    {
        $this->model->where('user_id', $userId)->delete();
    }
}
