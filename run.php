<?php

require 'vendor/autoload.php';

use Acme\Basket\Basket;
use Acme\Basket\Product;
use Acme\Basket\Delivery\DeliveryCalculator;
use Acme\Basket\Offer\BuyOneGetSecondHalfPriceOffer;

$catalogue = [
    'R01' => new Product('R01', 'Red Widget', 32.95),
    'G01' => new Product('G01', 'Green Widget', 24.95),
    'B01' => new Product('B01', 'Blue Widget', 7.95),
];

$basket = new Basket(
    $catalogue,
    new DeliveryCalculator(),
    [new BuyOneGetSecondHalfPriceOffer('R01')]
);

$basket->add('B01');
$basket->add('G01');

echo $basket->total() . PHP_EOL;