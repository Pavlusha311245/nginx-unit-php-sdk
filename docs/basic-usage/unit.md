# Unit

## Create unit object

```php
$unit = new Unit(
    socket: '/usr/local/var/run/unit/control.sock',
    address: 'http://localhost'
);
```

## Get unit socket

```php
$unit->getSocket();
```

## Get unit address

```php
$unit->getAddress();
```

## Clear config

```php
$unit->removeConfig();
```
