<?php

namespace App\Service\InvoiceService;

use App\Service\Arrayable;
use App\Service\BookService\Book;

/**
 * Class InvoiceItem
 *
 * @package App\Service\InvoiceService
 */
class InvoiceItem implements Arrayable
{
    /**
     * @var Book
     */
    private $book;
    private $quantity;

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @param Book $book
     *
     * @return InvoiceItem
     */
    public function setBook(Book $book)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
                "book" => $this->book->toArray(),
                "price" => $this->getPrice(),
                "quantity" => $this->getQuantity()
        ];
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->book->getPrice() * $this->quantity;
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
     * @return InvoiceItem
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
}
