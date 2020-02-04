<?php

namespace App\Service\InvoiceService\Discount;

use App\Service\InvoiceService\InvoicePrice;
use App\Service\InvoiceService\InvoicePriceInterface;

/**
 * Class BaseDiscount
 *
 * @package App\Service\InvoiceService\Discount
 */
abstract class BaseDiscount
{
    /**
     * @var InvoicePrice
     */
    protected $invoicePrice = 0;
    protected $discountAmount = 0;
    protected $discountName = '';

    /**
     * @return string
     */
    public function getDiscountName(): string
    {
        return $this->discountName;
    }


    /**
     * @inheritDoc
     */
    public function getDiscountAmount(): float
    {
        return $this->discountAmount;
    }

    /**
     * @inheritDoc
     */
    public function isCombinable(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function setInvoicePrice(InvoicePriceInterface $invoicePrice)
    {
        $this->invoicePrice = $invoicePrice;
    }

}
