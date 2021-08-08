<?php

namespace App\Repositories\Cart;

use App\Repositories\RepositoryInterface;

interface CartRepositoryInterface extends RepositoryInterface
{
    /**
     * getModel
     *
     * @return void
     */
    public function getModel();

    /**
     * getCartByUserAndBook
     *
     * @param  int $bookId
     * @param  int $userId
     * @return object
     */
    public function getCartByUserAndBook($bookId, $userId);

    /**
     * getTotalBookOfUser
     *
     * @param  int $userId
     * @return int
     */
    public function getTotalBookOfUser($userId);

    /**
     * deleteAllCart
     *
     * @param  int $userId
     * @return void
     */
    public function deleteAllCart($userId);
}
