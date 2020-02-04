<?php

namespace App\Controller;

use App\Response\DefaultResponse;
use App\Service\BookService\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController
 *
 * @package App\Controller
 */
class BookController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/book", name="get_books",methods={"GET"})
     * @param BookService $bookService
     *
     * @param Request $request
     *
     * @return DefaultResponse
     */
    public function getBooks(BookService $bookService, Request $request)
    {
        $options['keyword'] = $request->query->get('q');
        $options['category'] = $request->query->get('category');

        $from = $request->query->get('from') ?? 0;
        $max = $request->query->get('max') ?? 12;

        return new DefaultResponse($bookService->getBooks($from, $max, $options));
    }

    /**
     * @Route("/book/{id}", name="get_book",methods={"GET"})
     */
    public function getBook()
    {
    }


}
