<?php

declare(strict_types=1);

namespace Acme\Basket\Tests;

use PHPUnit\Framework\TestCase;
use Acme\Basket\Basket;
use Acme\Basket\Product;
use Acme\Basket\Delivery\DeliveryCalculator;
use Acme\Basket\Offer\BuyOneGetSecondHalfPriceOffer;

final class BasketTest extends TestCase
{
    private function createBasket(): Basket
    {
        $catalogue = [
            'R01' => new Product('R01', 'Red Widget', 32.95),
            'G01' => new Product('G01', 'Green Widget', 24.95),
            'B01' => new Product('B01', 'Blue Widget', 7.95),
        ];

        return new Basket(
            $catalogue,
            new DeliveryCalculator(),
            [new BuyOneGetSecondHalfPriceOffer('R01')]
        );
    }

    public function testBasketExampleOne(): void
    {
        $basket = $this->createBasket();
        $basket->add('B01');
        $basket->add('G01');

        $this->assertEquals(37.85, $basket->total());
    }

    public function testBasketExampleTwo(): void
    {
        $basket = $this->createBasket();
        $basket->add('R01');
        $basket->add('R01');

        $this->assertEquals(54.37, $basket->total());
    }

    public function testBasketExampleThree(): void
    {
        $basket = $this->createBasket();
        $basket->add('R01');
        $basket->add('G01');

        $this->assertEquals(60.85, $basket->total());
    }

    public function testBasketExampleFour(): void
    {
        $basket = $this->createBasket();
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');

        $this->assertEquals(98.27, $basket->total());
    }

    public function testInvalidProductThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $basket = $this->createBasket();
        $basket->add('INVALID');
    }
}