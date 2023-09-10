
<p align="center">
<img style="text-aligh: center" src="https://15804523-files.gitbook.io/~/files/v0/b/gitbook-x-prod.appspot.com/o/spaces%2F77F3kdmGsRkZFelMUJq1%2Ficon%2FnsTZCyEjC1z8LJWkzLro%2F%D1%8B.svg?alt=media&token=ce321f03-8fdf-4c4d-aaef-888183f713f6" width="200" alt="Company logo">
</p>

<p align="center">
<b style="font-size: 2rem">PHP SDK for Nginx Unit</b>
</p>

<p align="center">
<a href="https://packagist.org/packages/pavlusha311245/unit-php-sdk"><img src="https://img.shields.io/packagist/v/Pavlusha311245/unit-php-sdk?labelColor=%231e293b&color=%23702963&link=https%3A%2F%2Fpackagist.org%2Fpackages%2Fpavlusha311245%2Funit-php-sdk"></a>
<a href="https://unit-sdk.pavlusha.me/"><img src="https://img.shields.io/website?url=https%3A%2F%2Funit-sdk.pavlusha.me%2F&label=documentation&link=https%3A%2F%2Funit-sdk.pavlusha.me%2F"></a>
</p>

## About 

SDK allows developers to interact with the Nginx Unit web server through php classes. This project will help embed web server management into your projects

### Supported Versions

| Version | Nginx Unit Capability | Supported          |
|---------|:----------------------|--------------------|
| 0.5.x   | 1.30.0 & 1.31.0       | :white_check_mark: |
| < 0.4.x | 1.30.0                | :x:                |

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
```json
{
  "name": "user/example-php-project",
  "require": {
    "pavlusha311245/unit-php-sdk": "^0.6.0"
  },
  "autoload": {
    "psr-4": {
      "User\\ExamplePhpProject\\": "src/"
    }
  }
}

```
4. Install packages `composer install`

Congratulations! You installed package. Now you can use the full power of this SDK.

* Create `src/index.php` file
  1. `cd src` (`mkdir src` if folder doesn't exist)
  2. `touch src/index.php`
  3. `nano src/index.php`
* Paste code and change this line `socket: <your socket path to Nginx Unit>` for your configuration

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

* Run `php index.php`

### Documentation

More examples and detailed information can be found [in the documentation](https://unit-sdk.pavlusha.me/)

Happy coding 😊

## Changelog

More information about changes you can see [here](CHANGELOG.md)

## Contribution

More info about contribution you can
read [here](https://docs.github.com/en/get-started/quickstart/contributing-to-projects)

## Security Policy

If you find bugs and vulnerabilities, please
contact [unit@pavlusha.me](mailto:unit@pavlusha.me).

More info [here](SECURITY.md)
