<h1 align="center">
 Adaptation of the php-amqplib package for Laravel
</h1>

<p align="center">
    <img src="https://github.com/GeeksHubsAcademy/2020-geekshubs-media/blob/master/image/logo.png">	
</p>

![Packagist Downloads](https://img.shields.io/packagist/dt/geekshubs/rabbitmq?style=flat)
![Packagist License](https://img.shields.io/packagist/l/geekshubs/rabbitmq?logoColor=red)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/geekshubs/rabbitmq)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=GeeksHubsAcademy_RabbitMQ&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=GeeksHubsAcademy_RabbitMQ)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=GeeksHubsAcademy_RabbitMQ&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=GeeksHubsAcademy_RabbitMQ)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=GeeksHubsAcademy_RabbitMQ&metric=security_rating)](https://sonarcloud.io/dashboard?id=GeeksHubsAcademy_RabbitMQ)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=GeeksHubsAcademy_RabbitMQ&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=GeeksHubsAcademy_RabbitMQ)

Adaptation of the php-amqplib package for use in Laravel made with much :two_hearts:

For more information on php-aqpmqblib package visit their <a href="https://github.com/php-amqplib/php-amqplib">repository</a>


## 🚀 Installation

Require the `geekshubs/rabbitmq` package in your `composer.json` and update your dependencies:
```sh
composer require geekshubs/rabbitmq
```
In app/config/app.php add the following :

The ServiceProvider to the providers array :

```php
Geekshubs\RabbitMQ\RabbitMQServiceProvider::class,
```

###  :bulb: Lumen

On Lumen, just register the ServiceProvider manually in your `bootstrap/app.php` file:

```php
//Add lines to error reflection class
$app->instance('path.config', app()->basePath() . DIRECTORY_SEPARATOR . 'config');
$app->instance('path.storage', app()->basePath() . DIRECTORY_SEPARATOR . 'storage');
```

## :space_invader: Examples
In this Video 
https://youtu.be/wsMW1ylogl0

In [this Repo](https://github.com/xavi78/rabbitmqinlaravel)


## :mag_right: Change log
Please see <a href="https://github.com/GeeksHubsAcademy/RabbitMQ/blob/master/changelog.md">CHANGELOG</a> for more information what has changed recently.


## :superhero_woman: Contribute.
Feel free to make as many pull requests as you think fit, because there are so many things to do, all help is welcome.

Here is a guide if you want to take a look(https://github.com/GeeksHubsAcademy/2020-geekshubs-convenio/blob/master/contributing.md)

If you find a bug, let us know <a href="https://github.com/GeeksHubsAcademy/RabbitMQ/issues">here</a> .

If you request a new  <a href ="https://github.com/GeeksHubsAcademy/RabbitMQ/issues"> feature</a>.








