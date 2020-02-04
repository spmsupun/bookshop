<?php

namespace App\Service\InvoiceService\Discount;

use App\Service\InvoiceService\InvoiceItem;

/**
 * Class ChildrenBookDiscount
 *
 * @package App\Service\InvoiceService\Discount
 */
class ChildrenBookDiscount extends BaseDiscount implements DiscountInterface
{
    protected $discountName = "Children Discount";

    public function generateDiscount(): void
    {
        $numOfChildrenBook = 0;

        $items = $this->invoicePrice->getInvoice()->getItems();

        /** @var InvoiceItem $item */
        foreach ($items as $item) {
            if ($item->getBook()->getCategory() == 'children') {
                $numOfChildrenBook += $item->getQuantity();
            }
        }

        if ($numOfChildrenBook >= 5) {
            $this->discountAmount = ($this->invoicePrice->getCategoryTotal()['children'] ?? 0) * 10 / 100;
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

}
