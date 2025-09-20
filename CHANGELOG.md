# CHANGELOG

## v0.9.0 - [2025/09/20]

- Added new class `Telemetry` and `TelemetryProtocolEnum` for telemetry support
- Added `ModuleStatisticsInterface` and class `ModuleStatistics` for module statistics
- Added enum ApiPathEnum for managing API paths
- Added methods `getRouteBlock` and `removeRouteBlock` in `Route` class

## v0.8.0 - [2024/09/10]

- Updated application classes
- Removed doc folder
- Updated tests

## v0.7.0 - [2024/04/07]

- Now SDK support connection via only address.
- All private fields renamed from `_pattern` to `pattern`
- Some classes become a builders
- Updated PhpTarget class
- Added PhpOptions class
- Update Unit tests
- Added more classes for better support of PHP applications
- Added more classes information

## v0.6.0 - [2023/09/13] _Release on Programmer's Day. Happy holiday everyone :)_

- Rename method in ListenerPass getPassType() to getType()
- Added PythonApplication, PerlApplication, WebAssemblyApplication
- Added traits
- Updated NodeJsApplication, JavaApplication, GoApplication
- Updated package namespace from Pavlusha311245\UnitPhpSdk to UnitPhpSdk
- Update UnitRequest. Replaced curl with guzzle package
- Moved ListenerPass to Listener\ListenerPass
- Mark some class as Arrayble

## v0.5.0 - [2023/09/01]

- Added ProccessIsolation implementation
- Added Upstream class
- Added phpstan
- Updated RouteAction and RouteMatch. Added toArray methods
- Updated Config class
- Updated Unit class

## v0.4.0 - [2023/08/02]

- Added more Applications, Requests and Connection Statistics classes
- Added ListenerPass class
- Added AccessLog class
- Updated Unit and Config classes
- Added Pest tests
- Added linter

## v0.3.2 - [2023/07/19]

- Fixed issues with nullable objects and values
- Added `setListener($listener)` method to Application

## v0.3.1 - [2023/07/18]

- Removed method.

## v0.3.0 - [2023/07/17]

- Removed Application class
- Added Application classes based on abstraction
- Updated Route action and match classes
- Added enums (HttpSchemeEnum, HttpMethodsEnum)
- Updated Config and Unit classes

## v0.2.0 - [2023/07/16]

- Added new method `getListenerByPort`
- Added methods for implementation
    - `setApplicationLogPath($path)`
    - `setApplicationLogFormat($format)`
- Replaced arrays to object in Route
- Updated doc

## v0.1.0 - [2023/07/13] (Experimental version)

- Created project
