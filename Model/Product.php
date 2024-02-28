<?php

namespace Model;

class Product
{
    public function __construct(
        public string $name,
        public string $description,
        public int $price,
        public ?float $id = null
    )
    {
    }

}