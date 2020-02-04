<?php

namespace App\Service\InvoiceService;

use App\Service\Arrayable;
use App\Service\InvoiceService\Discount\DiscountInterface;

/**
 * Class InvoicePrice
 *
 * @package App\Service\InvoiceService
 */
class InvoicePrice implements InvoicePriceInterface, Arrayable
{
    /**
     * @var InvoiceInterface
     */
    private $invoice;
    /**
     * @var DiscountInterface[]
     */
    private $discounts;
    private $total = 0;
    private $subTotal = 0;
    private $categoryTotal = [];
    private $addedDiscount = [];
    /**
     * @var float
     */
    private $discountsAmount;

    /**
     * InvoicePrice constructor.
     *
     * @param InvoiceInterface $invoice
     */
    public function __construct(InvoiceInterface $invoice)
    {
        $this->invoice = $invoice;
    }

    public function generate()
    {
        $this->generatePrice();
        $this->generateDiscount();
    }

    function generatePrice()
    {
        /** @var InvoiceItem $item */
        foreach ($this->invoice->getItems() as $item) {
            $category = $item->getBook()->getCategory();
            if (!isset($this->categoryTotal[$category])) {
                $this->categoryTotal[$category] = 0;
            }

            $this->categoryTotal[$category] += ($item->getBook()->getPrice() * $item->getQuantity());
        }

        $this->subTotal = $this->total = array_sum($this->categoryTotal);
    }

    function generateDiscount()
    {
        $availableDiscounts = [];

        /**
         * Check none combinable discount available
         *
         * @var DiscountInterface $discount
         */
        foreach ($this->discounts as $discount) {
            $discount->setInvoicePrice($this);
            if (!$discount->isCombinable()) {
                $availableDiscounts[] = $discount;
            }
        }
        /**
         * if not add all the discounts
         */
        if (empty($availableDiscounts)) {
            $availableDiscounts = $this->discounts;
        }


        /** @var DiscountInterface $discount */
        foreach ($availableDiscounts as $discount) {
            $discount->setInvoicePrice($this);
            $discount->generateDiscount();
            $this->discountsAmount += $discount->getDiscountAmount();
            if ($discount->getDiscountAmount()) {
                $this->addedDiscount[] = $discount->getDiscountName();
            }
        }
        $this->total -= $this->discountsAmount;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discountsAmount;
    }

    /**
     * @return float
     */
    public function getDiscountAmount(): float
    {
        return $this->discountsAmount;
    }

    /**
     * @inheritDoc
     */
    public function setDiscounts(DiscountInterface ...$discounts): void
    {
        $this->discounts = $discounts;
    }

    /**
     * @return InvoiceInterface
     */
    public function getInvoice(): InvoiceInterface
    {
        return $this->invoice;
    }

    /**
     * @return array
     */
    public function getCategoryTotal(): array
    {
        return $this->categoryTotal;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
                "sub_total" => $this->subTotal,
                "total" => $this->total,
                "discount_amount" => $this->discountsAmount,
                "added_discounts" => $this->addedDiscount,
        ];
    }
}
