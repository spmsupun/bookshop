<?php

namespace App\Service\InvoiceService;

use App\Service\CouponService\Coupon;

/**
 * Interface InvoiceInterface
 *
 * @package App\Service\InvoiceService
 */
interface InvoiceInterface
{
    /**
     * @return Coupon
     */
    public function getCoupon();

    /**
     * @param Coupon $coupon
     *
     * @return Invoice
     */
    public function setCoupon(Coupon $coupon);

    /**
     * @return mixed
     */
    public function getClientName();

    /**
     * @param mixed $clientName
     *
     * @return Invoice
     */
    public function setClientName($clientName);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param mixed $email
     *
     * @return Invoice
     */
    public function setEmail($email);

    /**
     * @return mixed
     */
    public function getDiscount();

    /**
     * @param mixed $discount
     *
     * @return Invoice
     */
    public function setDiscount($discount);

    /**
     * @return mixed
     */
    public function getCreatedDateTime();

    /**
     * @param mixed $createdDateTime
     *
     * @return Invoice
     */
    public function setCreatedDateTime($createdDateTime);

    /**
     * @return array
     */
    public function getItems();

    /**
     * @param InvoiceItem $items
     *
     * @return Invoice
     */
    public function addItems(InvoiceItem $items);

    /**
     * @return InvoicePriceInterface
     */
    public function getInvoicePrice(): InvoicePriceInterface;
}
