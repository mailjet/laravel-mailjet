<div align="center">

<img src="docs/img/logo.png" alt="Mailjet" width="220">

# Laravel Mailjet

**Fluent [Mailjet](https://www.mailjet.com/) API&nbsp;v3 integration &amp; mail transport for Laravel.**

Send transactional mail through the Laravel `Mail` facade, or talk to the full Mailjet
REST API — contacts, lists, campaigns, templates and webhooks — with an expressive wrapper.

<br>

[![Latest Version](https://img.shields.io/packagist/v/mailjet/laravel-mailjet.svg?style=flat-square&label=packagist)](https://packagist.org/packages/mailjet/laravel-mailjet)
[![Total Downloads](https://img.shields.io/packagist/dt/mailjet/laravel-mailjet.svg?style=flat-square)](https://packagist.org/packages/mailjet/laravel-mailjet)
[![PHP Version](https://img.shields.io/packagist/php-v/mailjet/laravel-mailjet.svg?style=flat-square)](composer.json)
[![Laravel](https://img.shields.io/badge/laravel-9.x%20—%2013.x-FF2D20.svg?style=flat-square&logo=laravel)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

</div>

---

## Table of contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Sending mail with the Mailjet transport](#sending-mail-with-the-mailjet-transport)
- [Using the Mailjet API](#using-the-mailjet-api)
- [Optional service providers](#optional-service-providers)
- [Sandbox mode](#sandbox-mode)
- [Documentation](#documentation)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

---

## Features

- 📨 **Drop-in mail transport** — set one env var and every `Mailable` / `Notification` goes through Mailjet.
- 🧩 **Full API v3 wrapper** — low-level `get` / `post` / `put` / `delete` plus high-level helpers, built on the official [`mailjet/mailjet-apiv3-php`](https://github.com/mailjet/mailjet-apiv3-php) client.
- 🗂️ **Resource managers** — dedicated, injectable services for contacts, lists, metadata, campaigns, campaign drafts, templates and event callbacks.
- 🧪 **Sandbox mode** — validate payloads in CI and local development without sending a single email.
- ⚡ **Zero-config setup** — package auto-discovery registers the provider and `Mailjet` facade for you.

## Requirements

| Package | Supported versions |
| --- | --- |
| PHP | `7.4` · `8.x` |
| Laravel | `9.x` – `13.x` |
| Symfony Mailer / Mailjet Mailer | `6.x` · `7.x` · `8.x` |

## Installation

```bash
composer require mailjet/laravel-mailjet
```

That's it. [Package auto-discovery](https://laravel.com/docs/packages#package-discovery) wires up the
`MailjetServiceProvider` and the `Mailjet` facade automatically.

<details>
<summary><strong>Manual registration</strong> (only if auto-discovery is disabled)</summary>

<br>

**Laravel 11 and newer** — `bootstrap/providers.php`:

```php
use Mailjet\LaravelMailjet\MailjetServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    MailjetServiceProvider::class,
];
```

**Laravel 10 and older** — `config/app.php`:

```php
'providers' => [
    // ...
    Mailjet\LaravelMailjet\MailjetServiceProvider::class,
],

'aliases' => [
    // ...
    'Mailjet' => Mailjet\LaravelMailjet\Facades\Mailjet::class,
],
```

</details>

## Configuration

Grab your API key and secret from the [Mailjet account settings](https://app.mailjet.com/account/api_keys).

**1. Add your credentials to `.env`:**

```env
MAILJET_APIKEY=your_api_key
MAILJET_APISECRET=your_api_secret

MAIL_FROM_ADDRESS=you@example.com
MAIL_FROM_NAME="Your App"

# Optional — process requests without actually sending
MAILJET_SANDBOX=false
```

**2. Register the service in `config/services.php`:**

```php
'mailjet' => [
    'key'     => env('MAILJET_APIKEY'),
    'secret'  => env('MAILJET_APISECRET'),
    // filter_var keeps the "true"/"false" env string honest (handy in Docker)
    'sandbox' => filter_var(env('MAILJET_SANDBOX', false), FILTER_VALIDATE_BOOLEAN),
],
```

> Need to tune the API URL, version, or the transactional/common/v4 clients?
> See the [full configuration reference](docs/configuration.md).

## Sending mail with the Mailjet transport

**1. Select the transport** in `.env`:

```env
MAIL_MAILER=mailjet
```

> Laravel 6 and older use the `MAIL_DRIVER` key instead.

**2. Declare the mailer** in `config/mail.php`:

```php
'mailers' => [
    // ...
    'mailjet' => [
        'transport' => 'mailjet',
    ],
],
```

**3. Send as usual** — no Mailjet-specific code required:

```php
use Illuminate\Support\Facades\Mail;

Mail::to($user)->send(new InvoicePaid($invoice));
```

Make sure the *from* address is a verified [Mailjet sender](https://app.mailjet.com/account/sender).
More patterns (Mailjet templates, variables, custom headers) live in the
[examples guide](docs/usage.md#usage-with-laravel-mailable-class).

## Using the Mailjet API

Import the facade:

```php
use Mailjet\LaravelMailjet\Facades\Mailjet;
```

### Low-level requests

```php
Mailjet::get($resource, $args, $options);
Mailjet::post($resource, $args, $options);
Mailjet::put($resource, $args, $options);
Mailjet::delete($resource, $args, $options);
```

Every call returns a `Mailjet\Response`, or throws a
`Mailjet\LaravelMailjet\Exception\MailjetException` on an API error.
Filter arguments are documented in the [Mailjet API reference](https://dev.mailjet.com/email-api/v3/apikey/).

### High-level helpers

```php
Mailjet::getAllLists($filters);
Mailjet::createList($body);
Mailjet::getListRecipients($filters);
Mailjet::getSingleContact($id);
Mailjet::createContact($body);
Mailjet::createListRecipient($body);
Mailjet::editListrecipient($id, $body);
```

### Custom requests

```php
$client = Mailjet::getClient(); // the underlying \Mailjet\Client instance
```

## Optional service providers

Each Mailjet resource has a focused, injectable manager. Register only the providers you use
in `config/app.php` (or `bootstrap/providers.php` on Laravel 11+):

| Service provider | Manages | Contract |
| --- | --- | --- |
| `Providers\ContactsServiceProvider` | Contacts, incl. deletion (API v4) | `ContactsV4Contract` |
| `Providers\ContactsListServiceProvider` | Contact lists | `ContactsListContract` |
| `Providers\ContactMetadataServiceProvider` | Contact properties / metadata | `ContactMetadataContract` |
| `Providers\CampaignServiceProvider` | Campaigns | `CampaignContract` |
| `Providers\CampaignDraftServiceProvider` | Campaign drafts | `CampaignDraftContract` |
| `Providers\TemplateServiceProvider` | Templates | `TemplateServiceContract` |
| `Providers\EventCallbackUrlServiceProvider` | Event (webhook) callback URLs | `EventCallbackUrlContract` |

```php
// config/app.php
'providers' => [
    // ...
    Mailjet\LaravelMailjet\Providers\ContactsServiceProvider::class,
],
```

Then resolve the manager wherever you need it:

```php
use Mailjet\LaravelMailjet\Services\ContactsV4Service;

public function handle(ContactsV4Service $contacts)
{
    $contacts->delete(351406781);
}
```

## Sandbox mode

With `MAILJET_SANDBOX=true`, Mailjet validates the request and returns a successful
response **without delivering any email** — ideal for staging environments and automated tests.

```env
MAILJET_SANDBOX=true
```

Details in the [configuration reference](docs/configuration.md#sandbox-mode).

## Documentation

| Resource | Link |
| --- | --- |
| Configuration reference | [docs/configuration.md](docs/configuration.md) |
| Examples (campaigns, templates, Mailables) | [docs/usage.md](docs/usage.md) |
| Full docs site | <https://mailjet.github.io/laravel-mailjet/> |
| Mailjet API v3 | <https://dev.mailjet.com/> |
| PHP API client | <https://github.com/mailjet/mailjet-apiv3-php> |

## Testing

```bash
composer install
bin/phpunit
```

## Contributing

Issues and pull requests are welcome — see [CONTRIBUTING.md](CONTRIBUTING.md).

## License

Released under the [MIT License](LICENSE.md).
