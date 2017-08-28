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

Then, you need to add some informations in your configuration files. You can find your Mailjet API key/secret [here](https://app.mailjet.com/account/api_keys).

* In the providers array add the service providers you want to use, for example:

```php
'providers' => [
    ...
    Mailjet\LaravelMailjet\MailjetServiceProvider::class,
    Mailjet\LaravelMailjet\MailjetMailServiceProvider::class,
    ...
	Mailjet\LaravelMailjet\Providers\CampaignDraftServiceProvider::class
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

## Usage

To use it, you need to import the Mailjet Facade or any of the available Service-provider contracts in your file

    use Mailjet\LaravelMailjet\Facades\Mailjet;
	.....
	use Mailjet\LaravelMailjet\Contracts\CampaignDraftContract;


Then, in your code you can use one of the methods available in the `MailjetServices`.

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

All method return `Mailjet\Response` or throw a `MailjetException` in case of API error.

You can also get the Mailjet API client with the method `getClient()` and make your own request to Mailjet API.

