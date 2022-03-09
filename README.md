# eWarehousing Solutions Php Library

[![Latest Stable Version](http://poser.pugx.org/ewarehousing-solutions/ewhs-api-php/v)](https://packagist.org/packages/ewarehousing-solutions/ewhs-api-php) [![Total Downloads](http://poser.pugx.org/ewarehousing-solutions/ewhs-api-php/downloads)](https://packagist.org/packages/ewarehousing-solutions/ewhs-api-php) [![Latest Unstable Version](http://poser.pugx.org/ewarehousing-solutions/ewhs-api-php/v/unstable)](https://packagist.org/packages/ewarehousing-solutions/ewhs-api-php) [![License](http://poser.pugx.org/ewarehousing-solutions/ewhs-api-php/license)](https://packagist.org/packages/ewarehousing-solutions/ewhs-api-php) [![PHP Version Require](http://poser.pugx.org/ewarehousing-solutions/ewhs-api-php/require/php)](https://packagist.org/packages/ewarehousing-solutions/ewhs-api-php)

This library provides convenient access to the eWarehousing Solutions API from applications written in the php
language.

## Documentation
Api documentation: https://documenter.getpostman.com/view/19192450/UVeNn35H
-- Work in progress --


## Installation

```
composer req ewhs-api-php
```

### Requirements

- php 8.0+

## Usage

create client with username / password combination
```php
<?php

$connector = MiddlewareConnector::create(
    'username',
    'password',
    'wmsCode',
    'CustomerCode',
    MiddlewareConnector::BASE_URL_EU_DEV,
);

$response = $connector->getArticleCollectionRequest()->send($mockClient);

$response->status(); // 200, 201, 400, 500 etc...

$response->json();
```

create client with refresh token only
```php
<?php
$connector = MiddlewareConnector::createWithRefreshToken(
    'refreshToken',
    'wmsCode',
    'CustomerCode',
    MiddlewareConnector::BASE_URL_EU_DEV,
);

$response = $connector->getArticleCollectionRequest()->send($mockClient);
$response->status(); // 200, 201, 400, 500 etc...
$response->json();
```

## Development

This project is created using the tool [Saloon](https://docs.saloon.dev/). 
A PHP package that helps you write beautiful API integrations. It introduces a standardised, fluent syntax to communicate with third party services.

It's possible to just extend the MiddlewareConnector and apply your own custom logic, and follow their documentation.

# Support
[www.ewarehousing-solutions.nl](https://ewarehousing-solutions.nl/) — info@ewarehousing-solutions.nl
