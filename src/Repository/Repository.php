<?php

namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Repository
 *
 * @package App\Repository
 */
abstract class Repository extends EntityRepository
{

    protected $queryBuilder;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * UserRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->queryBuilder = $this->entityManager->createQueryBuilder();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     *
     * @param $data
     *
     * @return ArrayCollection
     */
    public function response($data)
    {
        $array = json_decode($this->serializer->serialize($data, 'json' , ['ignored_attributes' => ['category']]), true);
        return new ArrayCollection($array);
    }

}
