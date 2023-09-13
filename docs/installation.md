---
description: This page wants help you to start using package
---

# Installation

## Version Compatibility

| PHP version   | Nginx Unit version | Package Version |
| ------------- | ------------------ | --------------- |
| 8.2 or higher | 1.30.0 or higher   | 0.5.0           |

{% hint style="info" %}
The project uses curl requests, make sure the appropriate PHP extension is installed
{% endhint %}

## Install via composer

1. Install package via composer

```sh
composer require pavlusha311245/unit-php-sdk
```

2. Use in SDK in code

```php
<?php

use Pavlusha311245\UnitPhpSdk\Unit;

require '../vendor/autoload.php';

$unit = new Unit(
    socket: <your socket path to Nginx Unit>,
    address: 'http://localhost'
);

$unit->getConfig();
```
