<?php

namespace App\Tests\BookService;

use App\Repository\BookRepository;
use App\Service\BookService\Book;
use App\Service\BookService\BookService;
use App\Service\CouponService\Coupon;
use App\Service\InvoiceService\Discount\ChildrenBookDiscount;
use App\Service\InvoiceService\Discount\CouponDiscount;
use App\Service\InvoiceService\Invoice;
use App\Service\InvoiceService\InvoiceItem;
use App\Service\InvoiceService\InvoicePrice;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class BookServiceTest
 *
 * @package App\Tests\BookService
 */
class InvoiceServiceTest extends KernelTestCase
{
    /**
     * @var BookRepository|object|null
     */
    private $bookService;
    /**
     * @var BookService|object|null
     */
    private $InvoiceService;
    /**
     * @var \App\Service\CouponService\CouponService|object|null
     */
    private $couponService;

    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testMakeInvoiceDiscount()
    {
        $invoice = new Invoice();

        $name = "Book 1";
        $description = "Nine noble families wage war against each other in order to gain control over the mythical land of Westeros.";
        $price = 158.25;

        $book = new Book();
        $book->setName($name);
        $book->setDescription($description);
        $book->setPrice($price);
        $book->setCategory("children");
        $savedBook = $this->bookService->addBook($book);

        $invoiceItem = new InvoiceItem();
        $invoiceItem->setBook($savedBook);
        $invoiceItem->setQuantity(5);

        $invoice->addItems($invoiceItem);

        $invoice->setClientName("Supun Praneeth");
        $invoice->setEmail("contact@supun.xyz");

        //Set Pricing
        $invoicePrice = new InvoicePrice($invoice);
        $invoicePrice->setDiscounts(new ChildrenBookDiscount());
        $invoicePrice->generate();
        $invoice->setPricing($invoicePrice);

        $this->assertEquals($invoice->getInvoicePrice()->getTotal(), ($price * 5) - ($price * 5) * 10 / 100);
    }

    public function testMakeInvoiceWithCoupon()
    {
        $invoice = new Invoice();

        $name = "Book 1";
        $description = "Nine noble families wage war against each other in order to gain control over the mythical land of Westeros.";
        $price = 156;

        $book = new Book();
        $book->setName($name);
        $book->setDescription($description);
        $book->setPrice($price);
        $book->setCategory("fiction");
        $savedBook = $this->bookService->addBook($book);

        $invoiceItem = new InvoiceItem();
        $invoiceItem->setBook($savedBook);
        $invoiceItem->setQuantity(5);

        $invoice->addItems($invoiceItem);
        $invoice->setClientName("Supun Praneeth");
        $invoice->setEmail("contact@supun.xyz");

        //add coupon
        $coupon = new Coupon();
        $coupon->setCode("OBGEMAGE");
        $coupon->setDiscount(15);
        $coupon->setExpireDate(new DateTime('2020-04-05'));

        $savedCoupon = $this->couponService->addCoupon($coupon);

        $invoice->setCoupon($savedCoupon);

        //Set Pricing
        $invoicePrice = new InvoicePrice($invoice);
        $invoicePrice->setDiscounts(new CouponDiscount());
        $invoicePrice->generate();
        $invoice->setPricing($invoicePrice);

        $this->assertEquals($invoice->getInvoicePrice()->getTotal(), ($price * 5) - ($price * 5) * 15 / 100);
    }

    protected function setUp()
    {
        self::bootKernel();
        $this->couponService = self::$container->get('app.coupon_service');
        $this->bookService = self::$container->get('app.book_service');
        $this->InvoiceService = self::$container->get('app.invoice_service');
    }

}
