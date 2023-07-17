# PHP SDK for Nginx Unit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/Pavlusha311245/unit-php-sdk?labelColor=%231e293b&color=%23702963&link=https%3A%2F%2Fpackagist.org%2Fpackages%2Fpavlusha311245%2Funit-php-sdk)](https://packagist.org/packages/pavlusha311245/unit-php-sdk)
[![Documentation](https://img.shields.io/website?url=https%3A%2F%2Funit-sdk.pavlusha.me%2F&label=documentation&link=https%3A%2F%2Funit-sdk.pavlusha.me%2F)](https://unit-sdk.pavlusha.me/)

_THIS PROJECT IN DEVELOPMENT. DON'T USE IT IN PRODUCTION_

## Quick start

### Pre-requirements

* PHP >= 8.2
* PHP curl extension
* Composer >= 2

### Installation
* Create folder `mkdir example-php-project`
* Open folder cd `example-php-project`
* Init composer `composer init`
* Add package `composer require pavlusha311245/unit-php-sdk`

Congratulations! You installed package. Now you can use the full power of this SDK.

* Create `index.php` file
* Paste code and change this line `socket: <your socket path to Nginx Unit>` for your configuration
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
* Run index.php

#### Happy coding 😊

## Documentation

More information about API references you can find [here](https://unit-sdk.pavlusha.me/)

## Changelog

More information about changes you can see [here](CHANGELOG.md)

## Contribution

More info about contribution you can
read [here](https://docs.github.com/en/get-started/quickstart/contributing-to-projects)
