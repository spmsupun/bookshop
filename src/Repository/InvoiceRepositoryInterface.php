<?php

namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface InvoiceRepositoryInterface
 *
 * @package App\Repository
 */
interface InvoiceRepositoryInterface
{
    /**
     * @param $clientName
     * @param $email
     * @param $discount
     * @param $couponId
     *
     * @return ArrayCollection
     */
    public function saveInvoice($clientName, $email, $discount, $couponId):ArrayCollection;

    /**
     * @param int $invoiceId
     * @param int $bookId
     * @param int $quantity
     * @param float $price
     */
    public function addInvoiceItems(int $invoiceId, int $bookId, int $quantity, float $price);
}
