<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class CategoryRepository
 *
 * @package App\Repository
 */
class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getCategory($id): ArrayCollection
    {
        return $this->response($this->find($id));
    }

    /**
     * @inheritDoc
     */
    public function getCategories(): ArrayCollection
    {
        $categories = $this->queryBuilder->select("category")
                ->from(Category::class, 'category')->getQuery()->getResult();

        $data = [];

        /** @var Category $category */
        foreach ($categories as $category) {
            $categoryItem['id'] = $category->getId();
            $categoryItem['name'] = $category->getName();
            $categoryItem['key'] = $category->getCategoryKey();
            $data[] = $categoryItem;
        }

        return $this->response($data);
    }
}
