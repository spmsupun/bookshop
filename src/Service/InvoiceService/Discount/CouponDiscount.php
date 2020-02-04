<?php

namespace App\Service\InvoiceService\Discount;

/**
 * Class CouponDiscount
 *
 * @package App\Service\InvoiceService\Discount
 */
class CouponDiscount extends BaseDiscount implements DiscountInterface
{
    protected $discountName = "Coupon Discount";

    public function generateDiscount(): void
    {
        $coupon = $this->invoicePrice->getInvoice()->getCoupon();
        if ($coupon) {
            $this->discountAmount = $this->invoicePrice->getSubTotal() * $coupon->getDiscount() / 100;
        }
    }

    /**
     * @inheritDoc
     */
    public function getDiscountPercentage(): float
    {
        $coupon = $this->invoicePrice->getInvoice()->getCoupon();
        return $coupon->getDiscount();
    }

    /**
     * @inheritDoc
     */
    public function isCombinable(): bool
    {
        return $this->invoicePrice->getInvoice()->getCoupon() ? false : true;
    }

}
