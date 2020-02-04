<?php

namespace App\Service\BookService;

/**
 * Interface BookInterface
 *
 * @package App\Service\BookService
 */
interface BookInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getCategory(): string;

    /**
     * @return float
     */
    public function getPrice(): float;

}
