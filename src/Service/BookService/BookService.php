<?php

namespace App\Service\BookService;

use App\Repository\BookRepositoryInterface;
use App\Service\HelperService\HelperInterface;

/**
 * Class BookService
 *
 * @package App\Service\BookService
 */
class BookService
{
    /**
     * @var BookRepositoryInterface
     */
    private $repository;
    /**
     * @var HelperInterface
     */
    private $helper;

    /**
     * BookService constructor.
     *
     * @param BookRepositoryInterface $repository
     * @param HelperInterface $helper
     */
    public function __construct(BookRepositoryInterface $repository, HelperInterface $helper)
    {
        $this->repository = $repository;
        $this->helper = $helper;
    }

    /**
     * @param BookInterface $book
     *
     * @return Book
     */
    public function addBook(BookInterface $book): Book
    {
        $savedBook = $this->repository->addBook($book->getName(), $book->getDescription(), $book->getPrice(), $book->getCategory());
        return $this->getBook($savedBook->get("id"));
    }

    /**
     * @param $bookId
     *
     * @return Book
     */
    public function getBook($bookId): Book
    {
        $bookData = $this->repository->getBook($bookId);

        $book = new Book();
        $book->setId($bookData->get('id'));
        $book->setName($bookData->get('name'));
        $book->setDescription($bookData->get('description'));
        $book->setPrice($bookData->get('price'));
        $book->setCategory($bookData->get('category'));

        return $book;
    }

    /**
     * @param int $from
     * @param int $max
     * @param array $options
     *
     * @return array
     */
    public function getBooks($from = 0, $max = 12, $options = []): array
    {
        $books = $this->repository->getBooks($from, $max, $options)->toArray();
        foreach ($books as $k => $book) {
            $books[$k]['cover'] = $this->helper->getRandomImage();
        }

        return $books;
    }

}
