---
description: This page wants help you to start using package
---

# Installation

## Version Compatibility

| PHP version   | Nginx Unit version | Package Version |
| ------------- | ------------------ | --------------- |
| 8.2 or higher | 1.30.0 or higher   | 0.6.0           |

## Install via composer

1. Install package via composer

```sh
composer require pavlusha311245/unit-php-sdk
```

2. Use in SDK in code

```php
<?php

use UnitPhpSdk\Unit;

require '../vendor/autoload.php';

$unit = new Unit(
    socket: <your socket path to Nginx Unit>,
    address: 'http://localhost'
);

$unit->getConfig();
```
