<?php

namespace App\Service\InvoiceService;

use App\Service\InvoiceService\Discount\DiscountInterface;

/**
 * Interface InvoicePriceInterface
 *
 * @package App\Service\InvoiceService
 */
interface InvoicePriceInterface
{

    function generatePrice();

    function generateDiscount();

    /**
     * @return float
     */
    public function getTotal(): float;

    /**
     * @return float
     */
    public function getSubTotal(): float;

    public function generate();

    /**
     * @return float
     */
    public function getDiscount(): float;

    /**
     * @return float
     */
    public function getDiscountAmount(): float;

    /**
     * @param DiscountInterface ...$discounts
     *
     * @return void
     */
    public function setDiscounts(DiscountInterface ...$discounts): void;

    /**
     * @return InvoiceInterface
     */
    public function getInvoice(): InvoiceInterface;
}
