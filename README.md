# PHP/SAP common

**ATTENTION: THIS IS WORK IN PROGRESS AND NOT TO BE USED UNTIL THIS MESSAGE DISAPPEARS!**

[![License: MIT][license-mit]](LICENSE)
[![Build Status][travis-badge]][travis-ci]
[![Maintainability][maintainability-badge]][maintainability]
[![Test Coverage][coverage-badge]][coverage]

Exceptions and abstract classes containing logic for [PHP/SAP][phpsap] that is not specific to the underlying PHP module.

## Exceptions

The following exceptions are available in namespace `phpsap\exceptions`:

* `SapException` a generic exception inherited by all other exception.
* `ConfigKeyNotFoundException` in case a configuration key could not be found.
* `ConnectionFailedException` in case a connection could not be established.
* `UnknownFunctionException` in case the remote function doesn't exist.
* `FunctionCallException` in case the remote function call failed.

## Abstract classes

The abstract classes define the logic of the PHP/SAP library, that is not specific to the underlying PHP module used to talk to SAP.

These classes are available in namespace `phpsap\classes`:

* `AbstractConfigContainer` A JSON encodeable configuration container implementing PSR-11 for retrieving configuration parameters.
* `AbstractConfig` Configure basic connection parameters for SAP remote function calls, that are common to both connection types (A, and B)  implementing `\phpsap\interfaces\IConfig`.
* `AbstractConfigA` Configure connection parameters for SAP remote function calls using a specific SAP application server (type A) implementing `\phpsap\interfaces\IConfigA`.
* `AbstractConfigB` Configure connection parameters for SAP remote function calls using load balancing (type B) implementing `\phpsap\interfaces\IConfigB`.
* `AbstractConnection` Manages a PHP/SAP connection instance implementing `\phpsap\interfaces\IConnection`.
* `AbstractFunction` Manages a PHP/SAP remote function call implementing `\phpsap\interfaces\IFunction`.
* `AbstractRemoteFunctionCall` Proxy class to simplify PHP/SAP remote function calls implementing `\phpsap\interfaces\IFunction`.
* `ConnectionPool` Provides a static pool of available PHP/SAP connections. The connections are organized using their connection IDs. The connection ID ensures, that only one connection per configuration is established.

[phpsap]: https://php-sap.github.io
[license-mit]: https://img.shields.io/badge/license-MIT-blue.svg
[travis-badge]: https://travis-ci.org/php-sap/common.svg?branch=master
[travis-ci]: https://travis-ci.org/php-sap/common
[maintainability-badge]: https://api.codeclimate.com/v1/badges/843db325cd8b83ff8eca/maintainability
[maintainability]: https://codeclimate.com/github/php-sap/common/maintainability
[coverage-badge]: https://api.codeclimate.com/v1/badges/843db325cd8b83ff8eca/test_coverage
[coverage]: https://codeclimate.com/github/php-sap/common/test_coverage
