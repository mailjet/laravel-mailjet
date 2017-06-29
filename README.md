# Laravel Mailjet

[![Build Status](https://travis-ci.org/mailjet/laravel-mailjet.svg?branch=master)](https://travis-ci.org/mailjet/laravel-mailjet)
[![Packagist](https://img.shields.io/packagist/v/mailjet/laravel-mailjet.svg)](https://packagist.org/packages/mailjet/laravel-mailjet)
[![Packagist](https://img.shields.io/packagist/dt/mailjet/laravel-mailjet.svg)](https://packagist.org/packages/mailjet/laravel-mailjet)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/mailjet/laravel-mailjet/blob/master/LICENSE.md)

Laravel package for handling Mailjet API V3 using this wrapper: <https://github.com/mailjet/mailjet-apiv3-php>

It also provide a mailjetTransport for [Laravel mail feature](https://laravel.com/docs/master/mail)

## Installation

First, include the package in your dependencies

    composer require mailjet/laravel-mailjet

Then, you need to add some informations in your configuration files

* In the providers array

```php
'providers' => [
    ...
    Mailjet\LaravelMailjet\MailjetServiceProvider::class,
    Mailjet\LaravelMailjet\MailjetMailServiceProvider::class,
    ...
]
```

* In the aliases array

```php
'aliases' => [
    ...
    'Mailjet' => Mailjet\LaravelMailjet\Facades\Mailjet::class,
    ...
]
```

* In the services.php file

```php
mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
]
```

* In your .env file

```php
MAILJET_APIKEY=YOUR_APIKEY
MAILJET_APISECRET=YOUR_APISECRET
```

## Full configuration

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
    'transactionnal' => [
        'call' => true,
        'options' => [
            'url' => 'api.mailjet.com',
            'version' => 'v31',
            'call' => true,
            'secured' => true
        ]
    ],
    'common' => [
        'call' => true,
        'options' => [
            'url' => 'api.mailjet.com',
            'version' => 'v3',
            'call' => true,
            'secured' => true
        ]
    ]
]
```
You can pass settings to [MailjetClient](https://github.com/mailjet/mailjet-apiv3-php#new--version-120-of-the-php-wrapper-).

* `transactionnal`: settings to sendAPI client
* `common`: setting to MailjetClient accessible throught the Facade Mailjet

## Mail driver configuration

In order to use Mailjet as Mail driver, you need to change the mail driver in your `config/mail.php` or your `.env` file to `MAIL_DRIVER=mailjet`, and make sure you have a valid and authorised from-address configured on your Mailjet account.

For usage, check the [Laravel mail documentation](https://laravel.com/docs/master/mail)

## Usage

To use it, you need to import Mailjet Facade in your file

    use Mailjet\LaravelMailjet\Facades\Mailjet;


Then, in your code you can use one of the method available in the MailjetServices :

Low level API methods:

* `Mailjet::get($resource, $args, $options)`
* `Mailjet::post($resource, $args, $options)`
* `Mailjet::put($resource, $args, $options)`
* `Mailjet::delete($resource, $args, $options)`

High level API methods:

* `Mailjet::getAllLists($filters)`
* `Mailjet::createList($body)`
* `Mailjet::getListRecipients($filters)`
* `Mailjet::getSingleContact($id)`
* `Mailjet::createContact($body)`
* `Mailjet::createListRecipient($body)`
* `Mailjet::editListrecipient($id, $body)`

For more informations about the filters you can use in each methods, refer to the [Mailjet API documentation](https://dev.mailjet.com/email-api/v3/apikey/)

All method return Mailjet\Response or throw a MailjetException in case of API error.

You can also get the client with the method `getClient()` and make your own request to Mailjet API.

## ToDo

* Create Mailjet contract (Laravel 5.4 - DepInject <https://laravel.com/docs/5.4/contracts>)
* New feature: EventAPI (webhook), Campaign, stats, ...
* More Tests
