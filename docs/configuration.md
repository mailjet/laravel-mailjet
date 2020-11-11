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
    ]
]
```
You can pass settings to [MailjetClient](https://github.com/mailjet/mailjet-apiv3-php).

* `transactional`: settings for Send API
* `common`: setting to `MailjetClient` accessible through the Facade Mailjet.
* `url` (Default: `api.mailjet.com`): domain name of the API
* `version` (Default: `v3`): Mailjet API version (only working for Mailjet API v3)
* `call` (Default: `true`): Toggle if the API call is actually performed or mocked
* `secured` (Default: `true`): Toggle the usage of 'https'


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