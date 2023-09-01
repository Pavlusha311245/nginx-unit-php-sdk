# Prerequisites

## Pre-requirements

* PHP >= 8.2
* PHP curl extension
* [Composer](https://getcomposer.org/download/) >= 2

## Installation

1. Create folder `mkdir example-php-project`
2. Open folder `cd example-php-project`
3. Init composer `composer init`
4. Add package `composer require pavlusha311245/unit-php-sdk`

Congratulations. You installed package. Now you can use the full power of this SDK.&#x20;

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
