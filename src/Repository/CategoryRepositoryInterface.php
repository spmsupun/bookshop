<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface CategoryRepositoryInterface
 *
 * @package App\Repository
 */
interface CategoryRepositoryInterface
{

    /**
     * @param $id
     *
     * @return ArrayCollection
     */
    public function getCategory($id): ArrayCollection;

    /**
     * @param $id
     *
     * @return ArrayCollection
     */
    public function getCategories(): ArrayCollection;

}
