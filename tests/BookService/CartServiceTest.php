<?php

namespace App\Tests\BookService;

use App\Service\BookService\Book;
use App\Service\BookService\BookService;
use App\Service\CartService\Cart;
use App\Service\CartService\CartItem;
use App\Service\CartService\CartService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class BookServiceTest
 *
 * @package App\Tests\BookService
 */
class CartServiceTest extends KernelTestCase
{
    /**
     * @var BookService
     */
    private $bookService;
    /**
     * @var CartService
     */
    private $cartService;
    /**
     * @var string
     */
    private $sessionId;

    public function testAddToCart()
    {
        $name = "Game of Thrones";
        $description = "Nine noble families wage war against each other in order to gain control over the mythical land of Westeros.";
        $price = 158.25;

        $book = new Book();
        $book->setName($name);
        $book->setDescription($description);
        $book->setPrice($price);
        $book->setCategory("fiction");
        $savedBook = $this->bookService->addBook($book);

        $cartItem = new CartItem();
        $cartItem->setBook($savedBook);
        $cartItem->setQuantity(5);

        $cart = new Cart();
        $cart->addToCart($cartItem);
        $cart->setSessionId($this->sessionId);

        $this->cartService->addCart($cart);

        /** @var CartItem $cartItems */
        foreach ($cart->getItems() as $cartItems) {
            $this->assertEquals($cartItems->getBook()->getName(), $name);
            $this->assertEquals($cartItems->getBook()->getDescription(), $description);
            $this->assertEquals($cartItems->getBook()->getPrice(), $price);
            $this->assertEquals($cartItems->getBook()->getCategory(), "fiction");
            $this->assertEquals($cartItems->getQuantity(), 5);
        }
    }

    protected function setUp()
    {
        self::bootKernel();
        $this->sessionId = md5(time());
        $this->cartService = self::$container->get('app.cart_service');
        $this->bookService = self::$container->get('app.book_service');
    }

}
