<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * getModel
     *
     * @return void
     */
    public function getModel();

    /**
     * getListUser
     *
     * @return object
     */
    public function getListUser($fillter = []);
}
