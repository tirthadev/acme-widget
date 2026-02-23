<?php

declare(strict_types=1);

namespace Acme\Basket;

use Acme\Basket\Delivery\DeliveryCalculator;
use Acme\Basket\Offer\OfferInterface;
use InvalidArgumentException;

final class Basket
{
    private array $items = [];

    /**
     * @param Product[] $catalogue
     * @param OfferInterface[] $offers
     */
    public function __construct(
        private readonly array $catalogue,
        private readonly DeliveryCalculator $deliveryCalculator,
        private readonly array $offers = []
    ) {}

    public function add(string $productCode): void
    {
        if (!isset($this->catalogue[$productCode])) {
            throw new InvalidArgumentException("Invalid product code: {$productCode}");
        }

        $this->items[] = $productCode;
    }

    public function total(): float
    {
        $subtotal = array_reduce(
            $this->items,
            fn (float $carry, string $code) =>
                $carry + $this->catalogue[$code]->price(),
            0.0
        );

        $discount = array_reduce(
            $this->offers,
            fn (float $carry, OfferInterface $offer) =>
                $carry + $offer->apply($this->items, $this->catalogue),
            0.0
        );

        $subtotalAfterDiscount = $subtotal - $discount;

        $delivery = $this->deliveryCalculator
            ->calculate($subtotalAfterDiscount);

        return round($subtotalAfterDiscount + $delivery, 2);
    }
}