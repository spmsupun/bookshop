<?php

namespace App\Service\CartService;

use App\Service\BookService\BookInterface;

/**
 * Class CartItem
 *
 * @package App\Service\CartService
 */
class CartItem
{
    private $book;
    private $quantity;

    /**
     * @return BookInterface
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param BookInterface $book
     *
     * @return CartItem
     */
    public function setBook(BookInterface $book)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     *
     * @return CartItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

}
