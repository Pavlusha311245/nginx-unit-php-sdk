# CHANGELOG

## v0.7.0 - [In progress]

- Now SDK support connection via only address.

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
