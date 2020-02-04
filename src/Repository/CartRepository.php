<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Cart;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CartRepository
 *
 * @package App\Repository
 */
class CartRepository extends Repository implements CartRepositoryInterface
{

    /**
     * @param int $bookId
     * @param int $quantity
     *
     * @param string $sessionId
     *
     * @return mixed|void
     * @throws NonUniqueResultException
     */
    public function addToCart(int $bookId, int $quantity, string $sessionId)
    {
        $book = $this->entityManager->find(Book::class, $bookId);

        try {
            /** @var Cart $bookAvailability */
            $bookAvailability = $this->queryBuilder
                    ->select('cart')
                    ->from(Cart::class, 'cart')
                    ->andWhere('cart.sessionId = :session_id')
                    ->andWhere('cart.book = :book')
                    ->setParameter('book', $book)
                    ->setParameter('session_id', $sessionId)
                    ->getQuery()->getSingleResult();

            $bookAvailability->setQuantity($quantity + $bookAvailability->getQuantity());
            $this->entityManager->flush();
        } catch (NoResultException $exception) {
            $cart = new Cart();
            $cart->setBook($book);
            $cart->setQuantity($quantity);
            $cart->setCreatedDateTime(new DateTime('now'));
            $cart->setSessionId($sessionId);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
    }

    /**
     * @param int $bookId
     * @param string $sessionId
     *
     * @return mixed
     */
    public function removeFromCart(int $bookId, string $sessionId)
    {
        $book = $this->entityManager->find(Book::class, $bookId);

        try {
            $bookAvailability = $this->queryBuilder
                    ->select('cart')
                    ->from(Cart::class, 'cart')
                    ->andWhere('cart.sessionId = :session_id')
                    ->andWhere('cart.book = :book')
                    ->setParameter('book', $book)
                    ->setParameter('session_id', $sessionId)
                    ->getQuery()->getSingleResult();

            $this->entityManager->remove($bookAvailability);
            $this->entityManager->flush();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
    }

    /**
     * @param string $sessionId
     *
     * @return mixed
     */
    public function getCart(string $sessionId): ArrayCollection
    {
        $cart = $this->queryBuilder
                ->select('cart')
                ->from(Cart::class, 'cart')
                ->andWhere('cart.sessionId = :session_id')
                ->setParameter('session_id', $sessionId)
                ->getQuery()->getResult();

        $data = [];

        /** @var Cart $cartItem */
        foreach ($cart as $cartItem) {
            $dataItem['id'] = $cartItem->getId();
            $dataItem['quantity'] = $cartItem->getQuantity();
            $dataItem['session_id'] = $cartItem->getSessionId();
            $dataItem['created_date_time'] = $cartItem->getCreatedDateTime();

            $dataItem['book']['id'] = $cartItem->getBook()->getId();
            $dataItem['book']['name'] = $cartItem->getBook()->getName();
            $dataItem['book']['description'] = $cartItem->getBook()->getDescription();
            $dataItem['book']['price'] = $cartItem->getBook()->getPrice();
            $dataItem['book']['category'] = $cartItem->getBook()->getCategory()->getCategoryKey();
            $data[] = $dataItem;
        }

        return $this->response($data);
    }
}
