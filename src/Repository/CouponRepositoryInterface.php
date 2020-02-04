<?php

namespace App\Repository;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface CouponRepositoryInterface
 *
 * @package App\Repository
 */
interface CouponRepositoryInterface
{
    /**
     * @param string $code
     * @param float $discount
     * @param DateTime $expireDate
     *
     * @return mixed
     */
    public function addCoupon(string $code, float $discount, DateTime $expireDate): ArrayCollection;

    /**
     * @param string $coupon
     *
     * @return ArrayCollection
     */
    public function getCoupon(string $coupon): ?ArrayCollection;
}
