<?php

namespace App\Repository;

use App\Service\BookService\BookInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface BookRepositoryInterface
 *
 * @package App\Repository
 */
interface CartRepositoryInterface
{
    /**
     * @param int $book
     *
     * @param int $quantity
     *
     * @param string $sessionId
     *
     * @return mixed
     */
    public function addToCart(int $book, int $quantity, string $sessionId);

    /**
     * @param string $sessionId
     *
     * @return mixed
     */
    public function getCart(string $sessionId): ArrayCollection;

}
