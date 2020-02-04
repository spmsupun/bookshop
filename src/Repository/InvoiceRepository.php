<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Coupon;
use App\Entity\Invoice;
use App\Entity\InvoiceBooks;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends Repository implements InvoiceRepositoryInterface
{
    /**
     * @param $clientName
     * @param $email
     * @param $discount
     * @param $couponId
     *
     * @return ArrayCollection
     * @throws \Exception
     */
    public function saveInvoice($clientName, $email, $discount, $couponId): ArrayCollection
    {
        $coupon = null;
        if ($couponId) {
            $coupon = $this->entityManager->find(Coupon::class, $couponId);
        }

        $invoice = new Invoice();
        $invoice->setClientName($clientName);
        $invoice->setEmail($email);
        $invoice->setDiscount($discount);
        $invoice->setCoupon($coupon);
        $invoice->setCreatedDateTime(new DateTime('now'));

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        return $this->response($invoice);
    }

    /**
     * @param int $invoiceId
     * @param int $bookId
     * @param int $quantity
     * @param float $price
     *
     * @return ArrayCollection
     */
    public function addInvoiceItems(int $invoiceId, int $bookId, int $quantity, float $price)
    {
        $invoice = $this->entityManager->find(Invoice::class, $invoiceId);
        $book = $this->entityManager->find(Book::class, $bookId);

        $invoiceItem = new InvoiceBooks();
        $invoiceItem->setInvoice($invoice);
        $invoiceItem->setBook($book);
        $invoiceItem->setQuantity($quantity);
        $invoiceItem->setPrice($price);

        $this->entityManager->persist($invoiceItem);
        $this->entityManager->flush();

        return $this->response($invoiceItem);
    }
}
