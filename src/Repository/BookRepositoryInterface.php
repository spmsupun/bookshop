<?php

namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface BookRepositoryInterface
 *
 * @package App\Repository
 */
interface BookRepositoryInterface
{
    /**
     * @param $name
     * @param $description
     * @param $price
     * @param $category
     *
     * @return ArrayCollection
     */
    public function addBook(string $name, string $description, float $price, string $category): ArrayCollection;

    /**
     * @param $bookId
     *
     * @return mixed
     */
    public function getBook($bookId): ArrayCollection;

    /**
     * @param int $from
     * @param int $max
     *
     * @param $options
     *
     * @return ArrayCollection
     */
    public function getBooks($from = 0, $max = 12, $options = []): ArrayCollection;
}
