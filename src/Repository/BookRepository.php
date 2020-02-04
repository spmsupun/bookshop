<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class BookRepository
 *
 * @package App\Repository
 */
class BookRepository extends Repository implements BookRepositoryInterface
{

    /**
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string $categoryKey
     *
     * @return ArrayCollection
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function addBook(string $name, string $description, float $price, string $categoryKey): ArrayCollection
    {
        $category = $this->queryBuilder->select("category")
                ->from(Category::class, 'category')
                ->where("category.category_key = :category_key")
                ->setParameter("category_key", $categoryKey)
                ->getQuery()->getSingleResult();

        $book = new Book();
        $book->setName($name);
        $book->setDescription($description);
        $book->setPrice($price);
        $book->setCategory($category);
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $this->response($book);
    }

    /**
     * @param $bookId
     *
     * @return ArrayCollection
     */
    public function getBook($bookId): ArrayCollection
    {
        $bookItem = $this->entityManager->find(Book::class, $bookId);

        $book['id'] = $bookItem->getId();
        $book['name'] = $bookItem->getName();
        $book['description'] = $bookItem->getDescription();
        $book['price'] = $bookItem->getPrice();
        $book['category']['id'] = $bookItem->getCategory()->getId();
        $book['category']['name'] = $bookItem->getCategory()->getName();

        $book['category'] = $bookItem->getCategory()->getCategoryKey();

        return $this->response($book);
    }

    /**
     * @param int $from
     * @param int $max
     *
     * @param array $options
     *
     * @return ArrayCollection
     */
    public function getBooks($from = 0, $max = 12, $options = []): ArrayCollection
    {
        $books = [];
        $dbl = $this->queryBuilder->select("book")
                ->from(Book::class, 'book');

        if (isset($options['keyword'])) {
            $dbl = $dbl->where("book.name like '%{$options['keyword']}%'");
        }
        if (isset($options['category'])) {
            $dbl = $dbl->innerJoin('book.category', 'category')
                    ->where("category.name = '{$options['category']}'");
        }

        $dblQuery = $dbl->getQuery()->getDQL();

        $query = $this->entityManager->createQuery($dblQuery)
                ->setFirstResult($from)
                ->setMaxResults($max);

        $paginator = new Paginator($query, true);

        $result = $paginator->getQuery()->getResult();

        /** @var Book $bookItem */
        foreach ($result as $bookItem) {
            $book['id'] = $bookItem->getId();
            $book['name'] = $bookItem->getName();
            $book['description'] = $bookItem->getDescription();
            $book['price'] = $bookItem->getPrice();
            $book['category']['id'] = $bookItem->getCategory()->getId();
            $book['category']['name'] = $bookItem->getCategory()->getName();
            $books[] = $book;
        }
        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return $this->response($books);
    }

}
