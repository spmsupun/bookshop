<?php

namespace App\Service\InvoiceService\Discount;

use App\Repository\CategoryRepositoryInterface;
use App\Service\InvoiceService\InvoiceItem;

/**
 * Class CategoryBookDiscount
 *
 * @package App\Service\InvoiceService\Discount
 */
class CategoryBookDiscount extends BaseDiscount implements DiscountInterface
{
    protected $discountName = "Category Discount";
    /**
     * @var CategoryRepositoryInterface
     */
    private $repository;

    /**
     * CategoryBookDiscount constructor.
     *
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function generateDiscount(): void
    {
        $items = $this->invoicePrice->getInvoice()->getItems();
        $bookCategory = [];
        $discountAvailable = true;

        /** @var InvoiceItem $item */
        foreach ($items as $item) {
            if (isset($bookCategory[$item->getBook()->getCategory()])) {
                $bookCategory[$item->getBook()->getCategory()] += $item->getQuantity();
            } else {
                $bookCategory[$item->getBook()->getCategory()] = $item->getQuantity();
            }
        }

        $categories = $this->repository->getCategories()->toArray();
        foreach ($categories as $category) {
            $key = $category['key'];

            if (!isset($bookCategory[$key]) || (isset($bookCategory[$key]) && $bookCategory[$category['key']] < 10)) {
                $discountAvailable = false;
                break;
            }
        }

        if ($discountAvailable) {
            $this->discountAmount = $this->invoicePrice->getSubTotal() * 5 / 100;
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
