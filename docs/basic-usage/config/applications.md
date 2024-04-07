# Applications

{% hint style="info" %}
All applications are run with minimum parameters according to the examples in the [official documentation](https://unit.nginx.org/howto/samples/). Below is their creation with the help of SDK.
{% endhint %}

## PHP application

```php
$phpApplication = new \Pavlusha311245\UnitPhpSdk\Config\Application\PhpApplication();
$phpApplication->setRoot('/Users/apple/nginx-unit-examples/php');
$phpApplication->setScript('index.php');
```

## PERL application

```php
$perlApplication = new \Pavlusha311245\UnitPhpSdk\Config\Application\PerlApplication();
$perlApplication->setScript('/Users/apple/nginx-unit-examples/perl/index.psgi');
```

## Python application

```php
$pythonApplication = new \Pavlusha311245\UnitPhpSdk\Config\Application\PythonApplication();
$pythonApplication->setPath('/Users/apple/nginx-unit-examples/python');
$pythonApplication->setModule('index');
```

## NodeJs application

```php
$nodeJs = new \Pavlusha311245\UnitPhpSdk\Config\Application\NodeJsApplication();
$nodeJs->setWorkingDirectory('/Users/apple/nginx-unit-examples/nodejs');
$nodeJs->setExecutable('app.js');
```

## Java application

```php
$java = new \Pavlusha311245\UnitPhpSdk\Config\Application\JavaApplication();
$java->setWebApp('/Users/apple/nginx-unit-examples/java');
```

## Go application

```php
$go =  new \Pavlusha311245\UnitPhpSdk\Config\Application\GoApplication();
$go->setWorkingDirectory('/Users/apple/nginx-unit-examples/go');
$go->setExecutable('app');
```

## WebAssembly application

```php
$wasm = new \Pavlusha311245\UnitPhpSdk\Config\Application\WebAssemblyApplication();
$wasm->setModule('/Users/apple/nginx-unit-examples/rust/wasm_on_unit/target/wasm32-wasi/debug/wasm_on_unit.wasm');
$wasm->setRequestHandler('uwr_request_handler');
$wasm->setMallocHandler('luw_malloc_handler');
$wasm->setFreeHandler('luw_free_handler');
$wasm->setModuleInitHandler('uwr_module_init_handler');
$wasm->setModuleEndHandler('uwr_module_end_handler');
```
