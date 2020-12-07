# Laravel Mailjet

[![Build Status](https://travis-ci.org/mailjet/laravel-mailjet.svg?branch=master)](https://travis-ci.org/mailjet/laravel-mailjet)
[![Packagist](https://img.shields.io/packagist/v/mailjet/laravel-mailjet.svg)](https://packagist.org/packages/mailjet/laravel-mailjet)
[![Packagist](https://img.shields.io/packagist/dt/mailjet/laravel-mailjet.svg)](https://packagist.org/packages/mailjet/laravel-mailjet)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/mailjet/laravel-mailjet/blob/master/LICENSE.md)
[![Documentation](https://img.shields.io/badge/documentation-gh--pages-blue.svg)](https://mailjet.github.io/laravel-mailjet/)

Laravel package for handling Mailjet API v3 using this wrapper: <https://github.com/mailjet/mailjet-apiv3-php>

It also provides a mailjetTransport for [Laravel mail feature](https://laravel.com/docs/master/mail)

## Installation

First, include the package in your dependencies:

    composer require mailjet/laravel-mailjet

Then, you need to add some informations in your configuration files. You can find your Mailjet API key/secret [here](https://app.mailjet.com/account/api_keys).
Please also set your email from address and name.

* In the providers array:

```php
'providers' => [
    ...
    Mailjet\LaravelMailjet\MailjetServiceProvider::class,
    Mailjet\LaravelMailjet\MailjetMailServiceProvider::class,
    ...
]
```

* In the aliases array:

```php
'aliases' => [
    ...
    'Mailjet' => Mailjet\LaravelMailjet\Facades\Mailjet::class,
    ...
]
```

* In the services.php file:

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
]
```

* In your .env file:

```php
MAILJET_APIKEY=YOUR_APIKEY
MAILJET_APISECRET=YOUR_APISECRET
MAIL_FROM_ADDRESS=YOUR_EMAIL_FROM_ADDRESS
MAIL_FROM_NAME=YOU_FROM_NAME
```

## Full configuration

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
    'transactional' => [
        'call' => true,
        'options' => [
            'url' => 'api.mailjet.com',
            'version' => 'v3.1',
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
    ],
    'v4' => [
        'call' => true,
        'options' => [
            'url' => 'api.mailjet.com',
            'version' => 'v4',
            'call' => true,
            'secured' => true
        ]
    ],
]
```
You can pass settings to [MailjetClient](https://github.com/mailjet/mailjet-apiv3-php#new--version-120-of-the-php-wrapper-).

* `transactional`: settings to sendAPI client
* `common`: setting to MailjetClient accessible throught the Facade Mailjet
* `v4`: setting used for some DataProvider`s

## Mail driver configuration

In order to use Mailjet as your Mail driver, you need to update the mail driver in your `config/mail.php` or your `.env` file to `MAIL_MAILER=mailjet` (for Laravel 6 and older use MAIL_DRIVER constant instead), and make sure you are using a valid and authorised from email address configured on your Mailjet account. The sending email addresses and domain can be managed [here](https://app.mailjet.com/account/sender)

For Laravel 7+ you also need to specify new available mail driver in config/mail.php:
```
'mailers' => [
    ...

    'mailjet' => [
        'transport' => 'mailjet',
    ],
],
```
For usage, please check the [Laravel mail documentation](https://laravel.com/docs/master/mail)

## Usage

In order to usage this package, you first need to import Mailjet Facade in your code:

    use Mailjet\LaravelMailjet\Facades\Mailjet;


Then, in your code you can use one of the methods available in the MailjetServices.

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

You can also get the Mailjet API client with the method `getClient()` and make your own custom request to Mailjet API.

If you need to delete a contact, you need to register ContactsServiceProvider:
* In the providers array:

```php
'providers' => [
    ...
    \Mailjet\LaravelMailjet\Providers\ContactsServiceProvider::class,
    ...
]
```

and use it:
```php
public function handle(ContactsV4Service $contactsV4Service)
{
    $response = $contactsV4Service->delete(351406781);
    ...
}
```

## ToDo

* Add additional unit tests to increase code coverage.
