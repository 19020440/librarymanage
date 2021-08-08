<?php

namespace App\Repositories\Book;

use App\Repositories\RepositoryInterface;

interface BookRepositoryInterface extends RepositoryInterface
{
    /**
     * getListBook
     *
     * @return object
     */
    public function getListBook();

    /**
     * getTextCategory
     *
     * @param  int $int
     * @return string
     */
    public function getTextCategory($int);

    /**
     * getIndexCategory
     *
     * @param  string $text
     * @return int
     */
    public function getIndexCategory($text);

    /**
     * getListBookByName
     *
     * @param  string $name
     * @return object
     */
    public function getListBookByName($name);
}
