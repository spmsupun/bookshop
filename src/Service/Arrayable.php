<?php

namespace App\Service;

/**
 * Interface Arrayable
 *
 * @package App\Service
 */
interface Arrayable
{
    /**
     * @return array
     */
    public function toArray(): array;
}
