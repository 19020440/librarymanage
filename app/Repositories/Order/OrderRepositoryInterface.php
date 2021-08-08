<?php

namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * getModel
     *
     * @return void
     */
    public function getModel();

    /**
     * getListOrderByUser
     *
     * @param  mixed $userIds
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return object
     */
    public function getListOrderByUser($userIds, $day_start, $day_end);


    /**
     * updateStatus
     *
     * @param  object $order
     * @return object
     */
    public function updateStatus($order);
}
