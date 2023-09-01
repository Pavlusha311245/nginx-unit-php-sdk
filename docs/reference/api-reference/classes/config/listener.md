---
description: This class presents "listeners" section from config
---

# Listener

## Properties:

### string $\_link (Private)

Contains generated link

### array $\_pass (Private)

Contains divided pass value

### int $\_port (Private)

Contains port from pass key

## Methods:

### `__construct( private string $_listener, string $pass = '', private array $_tls = [], private array $_forwarded = [], )`

### `getLink()`

### `generateLink()`

### `parsePort() (Private)`

### `getPort()`

### `getForwarded()`

### `getPass()`

### `getTls()`

### `getListener()`

### `parseFromArray()`
