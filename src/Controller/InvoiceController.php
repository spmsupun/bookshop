<?php

namespace App\Controller;

use App\Repository\CategoryRepositoryInterface;
use App\Response\DefaultResponse;
use App\Service\CartService\CartService;
use App\Service\CouponService\CouponService;
use App\Service\InvoiceService\Discount\CategoryBookDiscount;
use App\Service\InvoiceService\Discount\ChildrenBookDiscount;
use App\Service\InvoiceService\Discount\CouponDiscount;
use App\Service\InvoiceService\InvoicePrice;
use App\Service\InvoiceService\InvoiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InvoiceController
 *
 * @package App\Controller
 */
class InvoiceController extends AbstractController
{

    use ControllerTrait;

    /**
     * @Route("/invoice", name="invoice")
     * @param InvoiceService $invoiceService
     *
     * @param CartService $cartService
     *
     * @param CouponService $couponService
     *
     * @param CategoryRepositoryInterface $repository
     *
     * @return DefaultResponse
     */
    public function getInvoice(
            InvoiceService $invoiceService,
            CartService $cartService,
            CouponService $couponService,
            CategoryRepositoryInterface $repository
    ) {
        $cart = $cartService->getCart($this->sessionId);

        //check the coupon
        $session = new Session();
        $couponCode = $session->get('coupon');
        $coupon = null;

        if ($couponCode) {
            $coupon = $couponService->getCoupon($couponCode);
        }

        $invoice = $invoiceService->getInvoice($cart, "Supun Praneeth", "spmsupun@gmail.com", $coupon);
        //Set Pricing
        $price = new InvoicePrice($invoice);
        $price->setDiscounts(new CategoryBookDiscount($repository), new ChildrenBookDiscount(), new CouponDiscount());
        $price->generate();
        $invoice->setPricing($price);

        return new DefaultResponse($invoice->toArray());
    }

    /**
     * @Route("/invoice/coupon/add", name="invoice_coupon_add", methods={"POST"})
     *
     * @param Request $request
     *
     * @param CouponService $couponService
     *
     * @return DefaultResponse
     * @throws \Exception
     */
    public function addCoupon(Request $request, CouponService $couponService)
    {
        $data = $this->asArray($request->getContent());
        $coupon = $couponService->getCoupon($data['coupon']);
        if ($coupon) {
            $session = new Session();
            $session->set('coupon', $data['coupon']);
            return new DefaultResponse([$data['coupon']]);
        } else {
            throw new \Exception("Invalid Coupon");
        }
    }

    /**
     * @Route("/invoice/coupon/remove", name="invoice_coupon_remove", methods={"POST"})
     *
     * @param Request $request
     *
     * @param CouponService $couponService
     *
     * @return DefaultResponse
     * @throws \Exception
     */
    public function removeCoupon(CouponService $couponService)
    {
        $session = new Session();
        $session->remove('coupon');
        return new DefaultResponse([]);
    }

}
