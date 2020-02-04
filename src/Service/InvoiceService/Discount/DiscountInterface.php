<?php

namespace App\Service\InvoiceService\Discount;

use App\Service\InvoiceService\InvoicePriceInterface;

/**
 * Interface DiscountInterface
 *
 * @package App\Service\InvoiceService\Discount
 */
interface DiscountInterface
{

    /**
     * @param InvoicePriceInterface $invoice
     *
     * @return mixed
     */
    public function setInvoicePrice(InvoicePriceInterface $invoice);

    public function generateDiscount(): void;

    /**
     * @return float
     */
    public function getDiscountPercentage(): float;

    /**
     * @return float
     */
    public function getDiscountAmount(): float;

    /**
     * @return bool
     */
    public function isCombinable(): bool;

    /**
     * @return string
     */
    public function getDiscountName(): string;

}
