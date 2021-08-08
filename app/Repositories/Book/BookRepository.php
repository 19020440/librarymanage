<?php

namespace App\Repositories\Book;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    protected $perPage = 10;

    //lấy model tương ứng
    public function getModel()
    {
        return Book::class;
    }

    public function getListBook($filter = [])
    {
        $books = $this->model;
        if (array_key_exists('category', $filter)) {
            $books = $books->where('category', 'like', $filter['category'] .  '%');
        }
        if (array_key_exists('info', $filter)) {
            if ($filter['filter'] == 'category') {
                $books = $books->where($filter['filter'], 'like', $filter['info'] . '%');
            } else {
                $books = $books->where($filter['filter'], 'like', '%' . $filter['info'] . '%');
            }
        }
        if (array_key_exists('sort', $filter)) {
            if ($filter['sort']) {
                $books = $books->orderBy('name');
            } else {
                $books = $books->orderByDesc('name');
            }
        }
        $books = $books->orderByDesc('updated_at')->paginate($this->perPage);
        return $books;
    }

    public function getTextCategory($int)
    {
        $int = (int) $int;
        return Book::TYPE[floor($int / 100)];
    }

    public function getIndexCategory($text)
    {
        return array_search($text, Book::TYPE, true);
    }

    public function getListBookByName($name)
    {
        return $this->model->where('name', 'like', '%' . $name . '%')->paginate($this->perPage);
    }

    public function getListBookByCategory($category)
    {
        return $this->model->where('category', 'like', floor($category / 100) . '%')->paginate(6);
    }

    //search in show data page
    public function searchDataAjax($request)
    {
        return $this->model->select($request)->distinct()->get();
    }
}
