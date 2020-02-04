<?php

namespace App\Repository;

use App\Entity\Coupon;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Coupon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coupon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coupon[]    findAll()
 * @method Coupon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouponRepository extends Repository implements CouponRepositoryInterface
{
    /**
     * @param string $code
     * @param float $discount
     * @param DateTime $expireDate
     *
     * @return ArrayCollection
     */
    public function addCoupon(string $code, float $discount, DateTime $expireDate): ArrayCollection
    {
        $coupon = new Coupon();
        $coupon->setCode($code);
        $coupon->setDiscount($discount);
        $coupon->setExpireDate($expireDate);

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        return $this->response($coupon);
    }

    /**
     * @param string $couponCode
     *
     * @return ArrayCollection
     */
    public function getCoupon(string $couponCode): ?ArrayCollection
    {
        try {
            $coupon = $this->queryBuilder
                    ->select('coupon')
                    ->from(Coupon::class, 'coupon')
                    ->andWhere('coupon.code = :code')
                    ->setParameter('code', $couponCode)
                    ->getQuery()
                    ->getSingleResult();
            return $this->response($coupon);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
