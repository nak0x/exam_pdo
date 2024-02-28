<?php
class Product
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
        public ?int $id = null
    )
    {
    }

}