<?php

namespace App\Service\HelperService;

use Symfony\Component\Finder\Finder;

/**
 * Class HelperService
 *
 * @package App\Service\HelperService
 */
class Helper implements HelperInterface
{

    /**
     * @return mixed
     */
    function getRandomImage():string
    {
        $finder = new Finder();

        $file_list = $finder->files()->in(__DIR__."/../../../public/images");

        $fileNames = [];
        foreach ($file_list as $fileItem) {
            $fileNames[] = $fileItem->getRelativePathname();
        }
        return 'images/'.($fileNames[array_rand($fileNames)]) ;
    }
}
