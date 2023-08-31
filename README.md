# PHP SDK for Nginx Unit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/Pavlusha311245/unit-php-sdk?labelColor=%231e293b&color=%23702963&link=https%3A%2F%2Fpackagist.org%2Fpackages%2Fpavlusha311245%2Funit-php-sdk)](https://packagist.org/packages/pavlusha311245/unit-php-sdk)
[![Documentation](https://img.shields.io/website?url=https%3A%2F%2Funit-sdk.pavlusha.me%2F&label=documentation&link=https%3A%2F%2Funit-sdk.pavlusha.me%2F)](https://unit-sdk.pavlusha.me/)

## About 

SDK allows developers to interact with the Nginx Unit web server through php classes

## Supported Versions

| Version | Supported          |
|---------|--------------------|
| 0.4.x   | :white_check_mark: |
| < 0.3.x | :x:                |

_THIS PROJECT IN DEVELOPMENT. DON'T USE IT IN PRODUCTION_

## Quick start

### Pre-requirements

* [PHP](https://www.php.net/) >= 8.2
* [PHP curl extension](https://www.php.net/manual/en/book.curl.php)
* [Composer](https://getcomposer.org/) >= 2
* [Nginx unit](https://unit.nginx.org/installation/) >= 1.30.0

### Installation

1. Create folder `mkdir example-php-project`
2. Open folder `cd example-php-project`
3. Crate composer.json file. Example below:
```shell
{
    "name": "pavlusha311245/example-php-project",
    "require": {
        "pavlusha311245/unit-php-sdk": "0.4.0"
    },
    "autoload": {
        "psr-4": {
            "Pavlusha\\ExamplePhpProject\\": "src/"
        }
    },
    "authors": [
        {
            "name": "Paul Zavadski",
            "email": "pavel.zavadski@cogniteq.com"
        }
    ]
}
```
4. Install packages `composer install`

Congratulations! You installed package. Now you can use the full power of this SDK.

* Create `src/index.php` file
  1. `cd src` (`mkdir src` if doesn't exist)
  2. `touch src/index.php`
  3. `nano src/index.php`
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

## Versioning
We use SemVer for versioning. For the versions available, see the tags on this repository.

## Contribution

More info about contribution you can
read [here](https://docs.github.com/en/get-started/quickstart/contributing-to-projects)

## Security Policy

If you find bugs and vulnerabilities, please
contact [zavadskiy.pavel2002@outlook.com](mailto:zavadskiy.pavel2002@outlook.com).

More info [here](SECURITY.md)
