<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $perPage = 20;

    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getListUser($fillter = [])
    {
        if (array_key_exists('name', $fillter)) {
            return $this->model->where('name', 'like', '%' . $fillter['name'] . '%')->paginate($this->perPage);
        }
        return $this->model->paginate($this->perPage);
    }

    public function getUserByUserName($username)
    {
        return $this->model->where('username', $username)->first();
    }

    public function getUserByName($name)
    {
        return $this->model->where('name', 'like', '%' . $name . '%')->get();
    }

    public function getListUserByName($name)
    {
        return $this->model->where('name', 'like', '%' . $name . '%')->paginate($this->perPage);
    }
}
