<?php

namespace App\Service\InvoiceService;

use App\Repository\InvoiceRepositoryInterface;
use App\Service\CartService\Cart;
use App\Service\CartService\CartItem;
use App\Service\CouponService\Coupon;

/**
 * Class InvoiceService
 *
 * @package App\Service\InvoiceService
 */
class InvoiceService
{

    /**
     * @var InvoiceRepositoryInterface
     */
    private $repository;

    /**
     * InvoiceService constructor.
     *
     * @param InvoiceRepositoryInterface $repository
     */
    public function __construct(InvoiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Invoice $invoice
     */
    public function saveInvoice(Invoice $invoice)
    {
        $savedInvoice = $this->repository->saveInvoice(
                $invoice->getClientName(),
                $invoice->getEmail(),
                $invoice->getDiscount(),
                $invoice->getCoupon()->getId()
        );

        /** @var InvoiceItem $invoiceItem */
        foreach ($invoice->getItems() as $invoiceItem) {
            $this->repository->addInvoiceItems(
                    $savedInvoice->get('id'),
                    $invoiceItem->getBook()->getId(),
                    $invoiceItem->getQuantity(),
                    $invoiceItem->getPrice()
            );
        }
    }

    /**
     * @param Cart $cart
     * @param string $name
     * @param string $email
     * @param Coupon $coupon
     *
     * @return Invoice
     */
    public function getInvoice(Cart $cart, string $name, string $email, Coupon $coupon = null): Invoice
    {
        $invoice = new Invoice();

        /** @var CartItem $item */
        foreach ($cart->getItems() as $item) {
            $invoiceItem = new InvoiceItem();
            $invoiceItem->setBook($item->getBook());
            $invoiceItem->setQuantity($item->getQuantity());
            $invoice->addItems($invoiceItem);
        }

        $invoice->setClientName($name);
        $invoice->setEmail($email);

        if ($coupon) {
            $invoice->setCoupon($coupon);
        }

        return $invoice;
    }


}
