## Full configuration

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
    'transactionnal' => [
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

* `transactional`: settings to Send API client
* `common`: setting to MailjetClient accessible throught the Facade Mailjet.
* `url` (Default: api.mailjet.com) : domain name of the API
version (Default: v3) : API version (only working for Mailjet API V3 +)
* `call` (Default: true) : turns on(true) / off the call to the API
* `secured` (Default: true) : turns on(true) / off the use of 'https'


## Mail driver configuration

In order to use Mailjet as Mail driver, you need to change the mail driver in your `config/mail.php` or your `.env` file to `MAIL_DRIVER=mailjet`, and make sure you have a valid and authorised from-address configured on your Mailjet account.

For usage, check the [Laravel mail documentation](https://laravel.com/docs/master/mail)