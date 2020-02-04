<?php

namespace App\Service\InvoiceService;

use App\Service\Arrayable;
use App\Service\CouponService\Coupon;

/**
 * Class Invoice
 *
 * @package App\Service\InvoiceService
 */
class Invoice implements InvoiceInterface, Arrayable
{
    private $id;
    private $coupon;
    private $clientName;
    private $email;
    private $discount;
    private $createdDateTime;
    private $items = [];
    /**
     * @var InvoicePriceInterface
     */
    private $invoicePrice;

    public function __construct()
    {
        $this->coupon = null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Invoice
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * @param Coupon $coupon
     *
     * @return Invoice
     */
    public function setCoupon(Coupon $coupon)
    {
        $this->coupon = $coupon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param mixed $clientName
     *
     * @return Invoice
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return Invoice
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     *
     * @return Invoice
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * @param mixed $createdDateTime
     *
     * @return Invoice
     */
    public function setCreatedDateTime($createdDateTime)
    {
        $this->createdDateTime = $createdDateTime;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param InvoiceItem $items
     *
     * @return Invoice
     */
    public function addItems(InvoiceItem $items)
    {
        $this->items[] = $items;
        return $this;
    }

    /**
     * @param InvoicePriceInterface $invoicePrice
     *
     * @return Invoice
     */
    public function setPricing(InvoicePriceInterface $invoicePrice): Invoice
    {
        $this->invoicePrice = $invoicePrice;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $items = [];
        /** @var InvoiceItem $item */
        foreach ($this->items as $item) {
            $items[] = $item->toArray();
        }

        $coupon = $this->coupon ? $this->coupon->toArray() : null;

        return [
                "coupon" => $coupon,
                "client_name" => $this->clientName,
                "email" => $this->email,
                "discount" => $this->discount,
                "items" => $items,
                "price" => $this->invoicePrice->toArray(),

        ];
    }

    /**
     * @return InvoicePriceInterface
     */
    public function getInvoicePrice(): InvoicePriceInterface
    {
        return $this->invoicePrice;
    }
}
