<?php

namespace App\Service\CartService;

use App\Service\Arrayable;
use App\Service\BookService\BookInterface;

/**
 * Class Cart
 *
 * @package App\Service\CartService
 */
class Cart implements Arrayable
{
    private $items = [];
    private $sessionId;

    /**
     * @param CartItem $cartItem
     */
    public function addToCart(CartItem $cartItem)
    {
        $this->items[] = $cartItem;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param mixed $sessionId
     *
     * @return Cart
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $data = [];
        /** @var CartItem $item */
        foreach($this->items as $item){
            $bookItem['book'] = $item->getBook()->toArray();
            $bookItem['quantity'] = $item->getQuantity();
            $data[] = $bookItem;
        }
        return $data;
    }
}
