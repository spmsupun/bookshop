<?php

namespace App\Service\BookService;

use App\Repository\CategoryRepository;

class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     */
    public function getCategory(int $id)
    {
        $this->repository->getCategory($id);
    }
}
