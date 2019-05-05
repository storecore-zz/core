StoreCore AMP HTML Framework
============================


StoreCore AMP PHP Interfaces
----------------------------

```php
interface LayoutInterface {
    getLayout ( void ) : string
    setLayout ( string $layout ) : void
}

interface LightboxGalleryInterface {
    isLightbox ( void ) : bool
    setLightbox ( [ bool $lightbox = true ] ) : void
}
```

AMP components that MAY be converted to an HTML tag SHOULD implement the
`StringableInterface` from the core `\StoreCore\Types` namespace.  This
interface converts data objects to strings using the magic PHP method
`__toString()`:

```php
interface \StoreCore\Types\StringableInterface {
    __toString ( void ) : string
}
```


StoreCore AMP Abstract Class
----------------------------

```php
abstract AbstractComponent implements LayoutInterface {
    __get ( string $name ) : string|int|null
    __set ( string $name [, mixed $value ] )
    getLayout ( void ) : string
    insert ( string $node ) : void
    setLayout ( string $layout ) : void
}
```

Copyright © 2019 StoreCore™.  All rights reserved.
