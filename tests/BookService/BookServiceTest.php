<?php

namespace App\Tests\BookService;

use App\Repository\BookRepository;
use App\Service\BookService\Book;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class BookServiceTest
 *
 * @package App\Tests\BookService
 */
class BookServiceTest extends KernelTestCase
{
    /**
     * @var BookRepository|object|null
     */
    private $bookService;

    /**
     * @return int
     */
    public function testAddBook()
    {
        $name = "Game of Thrones";
        $description = "Nine noble families wage war against each other in order to gain control over the mythical land of Westeros.";
        $price = 158.25;

        $book = new Book();
        $book->setName($name);
        $book->setDescription($description);
        $book->setPrice($price);
        $book->setCategory("fiction");
        $savedBook = $this->bookService->addBook($book);

        $this->assertEquals($savedBook->getName(), $name);
        $this->assertEquals($savedBook->getDescription(), $description);
        $this->assertEquals($savedBook->getPrice(), $price);


        return $savedBook->getId();
    }

    /**
     * @depends testAddBook
     *
     * @param $bookId
     */
    public function testGetBook($bookId)
    {
        $book = $this->bookService->getBook($bookId);
        $this->assertEquals($book->getId(), $bookId);
    }

    protected function setUp()
    {
        self::bootKernel();
        $this->bookService = self::$container->get('app.book_service');
    }

}
