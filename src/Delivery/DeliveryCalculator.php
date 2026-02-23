<?php

declare(strict_types=1);

namespace Acme\Basket\Delivery;

final class DeliveryCalculator
{
    public function calculate(float $subtotal): float
    {
        if ($subtotal >= 90) {
            return 0.0;
        }

        if ($subtotal >= 50) {
            return 2.95;
        }

        return 4.95;
    }
}