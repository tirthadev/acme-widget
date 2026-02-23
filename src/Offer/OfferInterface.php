<?php

declare(strict_types=1);

namespace Acme\Basket\Offer;

interface OfferInterface
{
    public function apply(array $items, array $catalogue): float;
}