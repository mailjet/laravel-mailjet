# Laravel Mailjet

[![Build Status](https://travis-ci.org/MoltenCoreIO/laravel-mailjet.svg?branch=master)](https://travis-ci.org/MoltenCoreIO/laravel-mailjet)
[![Packagist](https://img.shields.io/packagist/v/moltencore/laravel-mailjet.svg)](https://packagist.org/packages/moltencore/laravel-mailjet)
[![Packagist](https://img.shields.io/packagist/dt/moltencore/laravel-mailjet.svg)](https://packagist.org/packages/moltencore/laravel-mailjet)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/mailjet/MailjetSwiftMailer/blob/master/LICENSE.md)

Laravel package for handling Mailjet API V3 using this wrapper: <https://github.com/mailjet/mailjet-apiv3-php>

It also provide a mailjetTransport for [Laravel mail feature](https://laravel.com/docs/master/mail)

## Installation

First, include the package in your dependencies

    composer require moltencore/laravel-mailjet

Then, you need to add some informations in your configuration files

* In the providers array

```php
'providers' => [
    ...
    MoltenCore\LaravelMailjet\MailjetServiceProvider::class,
    ...
]
```

* In the aliases array

```php
'aliases' => [
    ...
    'Mailjet' => MoltenCore\LaravelMailjet\Facades\Mailjet::class,
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
MAILJET_FROMEMAIL=yourmail@example.com
MAILJET_FROMNAME="your name"
MAILJET_TOEMAIL="receiver@example.com"
```

## Make a request

To use it, you need to import Mailjet Facade in your file

    use Mailjet;


Then, in your code you can use one of the method available in the MailjetServices :

* getAllLists($filters)
* createList($body)
* getListRecipients($filters)
* getSingleContact($id)
* createContact($body)
* createListRecipient($body)
* editListrecipient($id, $body)
* sendMail($subject, $message)

For more informations about the filters you can use in each methods, refer to the [Mailjet API documentation](https://dev.mailjet.com/email-api/v3/apikey/)


## ToDo

* Client Call/Options
* Better \Mailjet\Client injection
