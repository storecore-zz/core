Product in Schema.org JSON-LD markup
====================================

## Full Example of Structured Product Data by Google

```html
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "Executive Anvil",
  "image": "http://www.example.com/anvil_executive.jpg",
  "description": "Sleeker than ACME's Classic Anvil, the Executive Anvil is perfect for the business traveler looking for something to drop from a height.",
  "mpn": "925872",
  "brand": {
    "@type": "Thing",
    "name": "ACME"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.4",
    "reviewCount": "89"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "USD",
    "price": "119.99",
    "priceValidUntil": "2020-11-05",
    "itemCondition": "http://schema.org/UsedCondition",
    "availability": "http://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "Executive Objects"
    }
  }
}
</script>
```

## StoreCore Workflow

The following steps outline the basic use of the StoreCore data objects for
structured product data.

### Product extends Thing

```php
// Create a product with basic product properties
$product = new \StoreCore\Types\Product();
$product->setName('Executive Anvil');
$product->setImage('http://www.example.com/anvil_executive.jpg');
$product->setDescription("Sleeker than ACME's Classic Anvil, the Executive Anvil is perfect for the business traveler looking for something to drop from a height.");
$product->setMPN(925872);
```

### Brand extends Intangible

```php
// Set the product's brand
$brand = new \StoreCore\Types\Brand();
$brand->setName('ACME');
$product->setBrand($brand);
```

### AggregateRating extends Rating

```php
// Set the product's overall rating
$rating = new \StoreCore\Types\AggregateRating();
$rating->setRatingValue(4.4);
$rating->setReviewCount(89);
$product->setAggregateRating($rating);
```

### Organization extends Thing

```php
// Set an organization as the offer's seller
$seller = new \StoreCore\Types\Organization();
$seller->setName('Executive Objects');
```

### Offer extends Intangible

```php
// Add an offer for the product's pricing
$offer = new \StoreCore\Types\Offer();
$offer->setPriceCurrency('USD')->setPrice(119.99);
$offer->setPriceValidUntil('2020-11-05');
$offer->setItemCondition('http://schema.org/UsedCondition');
$offer->setAvailability('http://schema.org/InStock');
$offer->setSeller($seller);
$product->setOffers($offer);
```

### Rich Snippet

```php
// Finally, output a <script> tag in JSON-LD
echo $product->getScript();
```
