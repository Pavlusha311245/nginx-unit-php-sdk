---
description: This is main class of Nginx Unit manipulation
---

# Unit

## Properties

### string $socket (Private readonly)

Contains path to socket

### string $address (Private readonly)

Contains http path

## Methods:

### `__construct(string $socket, string $address)`

### `getSocket()`

_Return type: String_

### `getAddress()`

_Return type: String_

### `getConfig()`

_Return type:_ [_Config_](config/)

### `getStatistics()`

_Return type:_ [_Statistic_](statistic.md)

### `getCertificates()`

_Return type:_ [_Certificate_](certificate-in-development.md)
