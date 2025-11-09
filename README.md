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

Then, you need to add some configuration. You can find your Mailjet API key/secret [here](https://app.mailjet.com/account/api_keys).

### Laravel 11.0+ (Recommended)

Laravel 11+ removed the `providers` and `aliases` arrays from `config/app.php`. This package uses **Laravel Package Auto-Discovery** (available since Laravel 5.5), which automatically registers the service provider and `Mailjet` facade alias when you install the package via Composer.

**No manual registration needed!** Just configure your credentials:

* Add to `config/services.php`:

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
]
```

* Add to your `.env` file:

```php
MAILJET_APIKEY=YOUR_APIKEY
MAILJET_APISECRET=YOUR_APISECRET
MAIL_MAILER=mailjet
MAIL_FROM_ADDRESS=YOUR_EMAIL_FROM_ADDRESS
MAIL_FROM_NAME=YOUR_FROM_NAME
```

* Add mailjet mailer to `config/mail.php`:

```php
'mailers' => [
    ...
    'mailjet' => [
        'transport' => 'mailjet',
    ],
],
```

**Optional:** If you have disabled auto-discovery, manually register the provider in `bootstrap/providers.php`:
```php
use Mailjet\LaravelMailjet\MailjetServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    MailjetServiceProvider::class,
];
```

### Laravel 9.x / 10.x (Auto-Discovery Available)

**Note:** Package auto-discovery works automatically in these versions too! Manual registration is only needed if you've disabled auto-discovery in your `composer.json`.

If you need manual registration, edit `config/app.php`:

```php
'providers' => [
    ...
    Mailjet\LaravelMailjet\MailjetServiceProvider::class,
    ...
],

'aliases' => [
    ...
    'Mailjet' => Mailjet\LaravelMailjet\Facades\Mailjet::class,
    ...
]
```

Then add to `config/services.php`:

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
]
```

And to your `.env` file:

```php
MAILJET_APIKEY=YOUR_APIKEY
MAILJET_APISECRET=YOUR_APISECRET
MAIL_MAILER=mailjet
MAIL_FROM_ADDRESS=YOUR_EMAIL_FROM_ADDRESS
MAIL_FROM_NAME=YOUR_FROM_NAME
```

**Note:** For Laravel 7+, you also need to add mailjet to `config/mail.php` (see [Mail driver configuration](#mail-driver-configuration) section below).

## Full configuration

For details head to [configuration doc](docs/configuration.md).

## Mail driver configuration

To use Mailjet as your Mail driver, make sure you've completed the installation steps above, including:

1. Set `MAIL_MAILER=mailjet` in your `.env` file (use `MAIL_DRIVER` for Laravel 6 and older)
2. Add the mailjet mailer to `config/mail.php` mailers array (Laravel 7+)
3. Configure a valid and authorized sender email address on your [Mailjet account](https://app.mailjet.com/account/sender)

For detailed mail usage, check the [Laravel mail documentation](https://laravel.com/docs/master/mail)

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

**Laravel 11+:** Add to `bootstrap/providers.php`:
```php
return [
    App\Providers\AppServiceProvider::class,
    Mailjet\LaravelMailjet\MailjetServiceProvider::class,
    Mailjet\LaravelMailjet\Providers\ContactsServiceProvider::class,
];
```

**Laravel 9.x/10.x:** Add to `config/app.php` providers array:
```php
'providers' => [
    ...
    \Mailjet\LaravelMailjet\Providers\ContactsServiceProvider::class,
    ...
]
```

Then use it:
```php
public function handle(ContactsV4Service $contactsV4Service)
{
    $response = $contactsV4Service->delete(351406781);
    ...
}
```
