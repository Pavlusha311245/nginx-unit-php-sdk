# Listeners

## Get all listeners

```php
$unit->getConfig()->getListeners()
```

## Get listener by port

```php
$unit->getConfig()->getListenerByPort(80)
```

## Adding listener

### Object creating

```php
// Create Nginx Unit listener
$listener = new Listener('*:8800', 'routes/laravel');

// Add listener to Config and upload it
$unit->getConfig()->addListener($listener);
```

### From file

```php
$unit->getConfig()->uploadListenerFromFile('/home/ubuntu/example.pem', '*:80')
```
