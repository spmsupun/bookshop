<?php

namespace App\Service\CouponService;

/**
 * Interface CouponInterface
 *
 * @package App\Service\InvoiceService
 */
interface CouponInterface
{

    /**
     * @return mixed
     */
    public function getId(): ?int;

    /**
     * @param mixed $id
     *
     * @return Coupon
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getCode(): ?string;

    /**
     * @param mixed $code
     *
     * @return Coupon
     */
    public function setCode(string $code);

    /**
     * @return mixed
     */
    public function getDiscount(): ?float;

    /**
     * @param mixed $discount
     *
     * @return Coupon
     */
    public function setDiscount($discount);

    /**
     * @return mixed
     */
    public function getExpireDate();

    /**
     * @param mixed $expireDate
     *
     * @return Coupon
     */
    public function setExpireDate($expireDate);

}
