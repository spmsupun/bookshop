<?php

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

/**
 * Class DataFixtures
 *
 * @package App\DataFixtures\ORM
 */
class DataFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $loader = new  NativeLoader();
        $objectSet = $loader->loadFile(__DIR__.'/characters.yml')->getObjects();

        foreach ($objectSet as $dataItem) {
            $manager->persist($dataItem);
        }
        $manager->flush();
    }

}
