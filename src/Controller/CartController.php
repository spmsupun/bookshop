<?php

namespace App\Controller;

use App\Response\DefaultResponse;
use App\Service\BookService\BookService;
use App\Service\CartService\Cart;
use App\Service\CartService\CartItem;
use App\Service\CartService\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CartController
 *
 * @package App\Controller
 */
class CartController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/cart/add", name="add_to_cart",methods={"POST"})
     * @param Request $request
     * @param CartService $cartService
     * @param BookService $bookService
     *
     * @return DefaultResponse
     */
    public function addToCart(Request $request, CartService $cartService, BookService $bookService)
    {
        $data = $this->asArray($request->getContent());
        $book = $bookService->getBook($data['book_id']);

        $cartItem = new CartItem();
        $cartItem->setBook($book);
        $cartItem->setQuantity($data['quantity']);

        $cart = new Cart();
        $cart->addToCart($cartItem);
        $cart->setSessionId($this->sessionId);
        $cartService->addCart($cart);

        return new DefaultResponse([]);
    }
    /**
     * @Route("/cart/item/remove", name="remove_to_cart",methods={"POST"})
     * @param Request $request
     * @return DefaultResponse
     */
    public function removeFromCart(Request $request, CartService $cartService, BookService $bookService)
    {
        $data = $this->asArray($request->getContent());
        $cartService->removeFromCart($data['book_id'],$this->sessionId);

        return new DefaultResponse([]);
    }

    /**
     * @Route("/cart/get", name="get_cart",methods={"GET"})
     * @param CartService $cartService
     *
     * @return DefaultResponse
     */
    public function getCart(CartService $cartService)
    {
        return new DefaultResponse($cartService->getCart($this->sessionId)->toArray());
    }

}
