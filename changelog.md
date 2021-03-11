# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [0.7.4] - 2020-03-11
### Added.
- Active Service Provider and add variables enviroment. https://github.com/GeeksHubs/RabbitMQ/commit/924bcb447b7d6b2b55bb9ec11a771aa53d5bcbda
- Add new response Service to reject queue error. https://github.com/GeeksHubs/RabbitMQ/commit/9262079425255bb59ef02c1018fcd369ae30c7af
### Changed.
- Fixed RequestRPC add resend parameter to reject meesage no ack
```php
 $rabbitMQ = app()->get('RabbitMQ');
 $rabbitMQ->createConnect("Geekshubs");
 $rabbitMQ->createExchange("geekshubs.command.message", "topic", null, true, null, null, null, null);
 $id = Str::uuid()->toString();
 $result = $rabbitMQ->requestRpc($id, "Geekshubs", "geekshubs_return", "geekshubs.command.message", "geekshubs.rpc", json_encode("Hola don pepito"), true);
```
### Removed.

## [0.7.3] - 2020-03-05
### Added.
- Add data connection in connection to use env variables.
- Add new Exceptions.
### Changed.
- Fixed Issues https://github.com/GeeksHubs/RabbitMQ/issues/3
### Removed.
- Remove logs in code.
- Remove dependency php-amqplib/php-amqplib
