# Acme Widget Basket – Proof of Concept

## Overview

This project implements a proof of concept basket system for Acme Widget Co.

The basket:

- Accepts products via product codes
- Applies special offer rules
- Applies delivery pricing rules
- Returns the final total

The solution is written in modern PHP with strict typing, clean architecture, and unit tests.

---

## Requirements

- PHP 8.1 or higher
- Composer
- PHPUnit 10 (installed via Composer)

---

## Installation

Clone the repository:

    git clone https://github.com/tirthadev/acme-widget.git
    cd acme-widget-basket

Install dependencies:

    composer install

---

## Running Tests

    composer test

or

    vendor/bin/phpunit

All provided example baskets are covered by automated tests.

---

## Product Catalogue

| Product       | Code | Price |
|--------------|------|-------|
| Red Widget   | R01  | 32.95 |
| Green Widget | G01  | 24.95 |
| Blue Widget  | B01  | 7.95  |

---

## Delivery Rules

Delivery charges are based on basket subtotal after discounts:

- Under 50 → 4.95
- Under 90 → 2.95
- 90 or more → Free delivery

Delivery logic is encapsulated in a dedicated `DeliveryCalculator` class.

---

## Special Offers

Current implemented offer:

Buy one Red Widget (R01), get the second half price.

The offer:

- Applies per pair
- Applies only to R01
- Works for any quantity
- Is implemented using an `OfferInterface` to allow future extension

Additional offers can be added by creating new classes that implement the interface.

---

## Example Baskets

| Basket                           | Total |
|----------------------------------|-------|
| B01, G01                         | 37.85 |
| R01, R01                         | 54.37 |
| R01, G01                         | 60.85 |
| B01, B01, R01, R01, R01          | 98.27 |

These scenarios are covered in `BasketTest`.

---

## Architecture

The project follows a clean, extensible structure.

### Core Classes

#### Product

Immutable value object representing a product.

#### Basket

Responsible for:

- Storing items
- Calculating subtotal
- Applying offers
- Applying delivery rules
- Returning final total

#### DeliveryCalculator

Handles delivery charge rules.

#### OfferInterface

Defines the contract for all promotional offers.

#### BuyOneGetSecondHalfPriceOffer

Implements the initial promotional rule.

---

## Design Decisions

### 1. Separation of Concerns

Basket does not contain delivery or promotional logic directly.  
Rules are injected via constructor dependency injection.

This allows:

- Easy testing
- Easy extension
- Clean responsibility boundaries

### 2. Extensibility

New offers can be added without modifying existing classes.

Example:

    class PercentageDiscountOffer implements OfferInterface

This follows the Open Closed Principle.

### 3. Strict Types

All files use:

    declare(strict_types=1);

This prevents implicit type coercion and improves reliability.

### 4. PSR 4 Autoloading

Namespaces follow PSR 4 standards:

    Acme\Basket\

Composer handles autoloading.

### 5. Error Handling

Invalid product codes throw:

    InvalidArgumentException

This ensures invalid input fails fast and predictably.

---

## Assumptions Made

- Delivery is calculated after promotional discounts.
- Prices are stored as floats for simplicity in this proof of concept.
- Monetary rounding is applied only once, at the final total.
- Only one offer applies to R01.
- No tax calculation is required.

In a production system, prices would likely be handled using integers representing minor units such as cents or a dedicated Money library to avoid floating point precision issues.

---

## Example Usage

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

    $basket->add('R01');
    $basket->add('R01');

    echo $basket->total(); // 54.37

---

## Future Improvements

Possible enhancements:

- Money value object using integers
- Percentage based offers
- Buy X get Y free offers
- Tiered discount strategies
- Promotion stacking rules
- API layer for integration
- Docker environment
- CI pipeline configuration

---

## Conclusion

This solution demonstrates:

- Clean object oriented design
- Test driven validation
- Extensible pricing architecture
- Production ready structure

It is designed to be easy to understand, easy to extend, and straightforward to maintain.