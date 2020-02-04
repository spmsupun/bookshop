<?php

namespace App\Service\CouponService;

use App\Repository\CouponRepositoryInterface;

/**
 * Class CouponService
 *
 * @package App\Service\CouponService
 */
class CouponService
{
    /**
     * @var CouponRepositoryInterface
     */
    private $repository;

    /**
     * CouponService constructor.
     *
     * @param CouponRepositoryInterface $repository
     */
    public function __construct(CouponRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Coupon $coupon
     *
     * @return Coupon
     */
    public function addCoupon(Coupon $coupon)
    {
        $savedCoupon = $this->repository->addCoupon($coupon->getCode(), $coupon->getDiscount(), $coupon->getExpireDate());

        //add coupon
        $coupon = new Coupon();
        $coupon->setId($savedCoupon->get('id'));
        $coupon->setCode($savedCoupon->get('code'));
        $coupon->setDiscount($savedCoupon->get('discount'));
        $coupon->setExpireDate($savedCoupon->get('expire_date'));

        return $coupon;
    }

    /**
     * @param $couponCode
     *
     * @return Coupon
     */
    public function getCoupon($couponCode): ?Coupon
    {
        $couponDetails = $this->repository->getCoupon($couponCode);
        if ($couponDetails) {
            $coupon = new Coupon();
            $coupon->setId($couponDetails->get('id'));
            $coupon->setExpireDate($couponDetails->get('expireDate'));
            $coupon->setCode($couponDetails->get('code'));
            $coupon->setDiscount($couponDetails->get('discount'));
            return $coupon;
        } else {
            return null;
        }
    }

}
