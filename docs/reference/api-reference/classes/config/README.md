---
description: This class contains Nginx Unit config data
---

# Config

## Properties

### $\_listeners (Private)

Contains array of values

### $\_routes (Private)

Contains array of values

### $\_applications (Private)

Contains array of values

### $\_upstreams (Private)

Contains array of values

## Methods

### `__construct(array $data)`

_Return type: Void_

### `getListeners()`

_Return type: Array_

### `getListenerByPort(int $port)`

_Return type: null or_ [_Listener_](listener.md)

### `getApplications()`

_Return type: Array_

### `getApplication($applicationName)`

Params:

* $applicationName - Existing application name from Nginx Unit config

_Return type:_ [_Application_](application-in-development/)

### `getRoutes()`

_Return type: Array_

### `getRoute($routeName)`

Params:

* $routeName - Existing route name from Nginx Unit config

_Return type:_ [_Route_](route-in-development/)

### `getUpstreams()`

_Return type: Mixed_

### `setApplicationLogPath($path) - (In development)`

### `setApplicationLogFormat($format) - (In development)`

### `toArray()`

_Return type: Array_
