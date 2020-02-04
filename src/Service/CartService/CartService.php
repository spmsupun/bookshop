<?php

namespace App\Service\CartService;

use App\Repository\CartRepositoryInterface;
use App\Service\BookService\Book;

/**
 * Class CartService
 *
 * @package App\Service\CartService
 */
class CartService
{
    /**
     * @var CartRepositoryInterface
     */
    private $repository;

    /**
     * CartService constructor.
     *
     * @param CartRepositoryInterface $repository
     */
    public function __construct(CartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Cart $cart
     */
    public function addCart(Cart $cart)
    {
        /** @var CartItem $cartItem */
        foreach ($cart->getItems() as $cartItem) {
            $this->repository->addToCart($cartItem->getBook()->getId(), $cartItem->getQuantity(), $cart->getSessionId());
        }
    }

    /**
     * @param $sessionId
     *
     * @return Cart
     */
    public function getCart(string $sessionId): Cart
    {
        $cartItems = $this->repository->getCart($sessionId)->toArray();
        $cart = new Cart();

        foreach ($cartItems as $item) {
            $book = new Book();
            $book->setId($item['book']['id']);
            $book->setName($item['book']['name']);
            $book->setDescription($item['book']['description']);
            $book->setPrice($item['book']['price']);
            $book->setCategory($item['book']['category']);

            $cartItem = new CartItem();
            $cartItem->setBook($book);
            $cartItem->setQuantity($item['quantity']);

            $cart->addToCart($cartItem);
            $cart->setSessionId($item['session_id']);

        }

        return $cart;
    }

}
