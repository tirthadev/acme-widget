<?php

declare(strict_types=1);

namespace Acme\Basket;

final class Product
{
    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly float $price
    ) {}

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }
}