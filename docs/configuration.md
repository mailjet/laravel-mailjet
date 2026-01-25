## Full configuration

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
    'sandbox' => env('MAILJET_SANDBOX', false),
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
You can pass settings to [MailjetClient](https://github.com/mailjet/mailjet-apiv3-php).

* `sandbox` (Default: `false`): When enabled, emails are processed but not actually sent - useful for testing
* `transactional`: settings for Send API
* `common`: setting to `MailjetClient` accessible through the Facade Mailjet.
* `url` (Default: `api.mailjet.com`): domain name of the API
* `version` (Default: `v3`): Mailjet API version (only working for Mailjet API v3)
* `call` (Default: `true`): Toggle if the API call is actually performed or mocked
* `secured` (Default: `true`): Toggle the usage of 'https'
* `v4`: setting used for some DataProvider`s

## Sandbox Mode

Sandbox mode allows you to test your email sending without actually delivering emails. When enabled, Mailjet API will validate your request and return a successful response, but no email will be sent.

This is particularly useful for:
- Testing in development/staging environments
- Validating email content and structure
- Running automated tests without sending real emails

To enable sandbox mode, add the following to your `.env` file:

```
MAILJET_SANDBOX=true
```

Or set it directly in your `config/services.php`:

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
    // Use filter_var to properly convert string "true"/"false" from env to boolean
    'sandbox' => filter_var(env('MAILJET_SANDBOX', false), FILTER_VALIDATE_BOOLEAN),
]
```

> **Note:** When using environment variables (especially in Docker), values are passed as strings. Use `filter_var()` with `FILTER_VALIDATE_BOOLEAN` to properly convert `"true"`/`"false"` strings to boolean values.

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
For usage, check the [Laravel mail documentation](https://laravel.com/docs/master/mail)