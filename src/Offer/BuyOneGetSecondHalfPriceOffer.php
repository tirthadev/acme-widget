<?php

declare(strict_types=1);

namespace Acme\Basket\Offer;

use Acme\Basket\Product;

final class BuyOneGetSecondHalfPriceOffer implements OfferInterface
{
    public function __construct(
        private readonly string $productCode
    ) {}

    public function apply(array $items, array $catalogue): float
    {
        $count = count(array_filter(
            $items,
            fn (string $code) => $code === $this->productCode
        ));

        if ($count < 2) {
            return 0.0;
        }

        $pairs = intdiv($count, 2);

        /** @var Product $product */
        $product = $catalogue[$this->productCode];

        return $pairs * ($product->price() / 2);
    }
}