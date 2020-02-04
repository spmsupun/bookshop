<?php

namespace App\Service\CouponService;

use App\Service\Arrayable;

/**
 * Class Coupon
 *
 * @package App\Service\InvoiceService
 */
class Coupon implements CouponInterface, Arrayable
{
    private $id;
    private $code;
    private $discount = 0;
    private $expireDate;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Coupon
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     *
     * @return Coupon
     */
    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     *
     * @return Coupon
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param mixed $expireDate
     *
     * @return Coupon
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
                "id" => $this->id,
                "code" => $this->code,
                "discount" => $this->discount,
                "expire_date" => $this->expireDate
        ];
    }
}
