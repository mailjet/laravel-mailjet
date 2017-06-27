# Laravel Mailjet

This library provide a wrapper arounr MailJet API for laravel. It is still in developpement, don't hesitate to add some method to the services.

## Installation

First, include the package in your dependencies

    composer require moltencore/laravel-mailjet

Then, you need to add some informations in your configuration files

* In the providers array

```php
'providers' => [
    ...
    MoltenCore\LaravelMailjet\MailjetProvider::class,
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
    'key' => 'YOUT_API_KEY',
    'secret' => 'YOUR_API_SECRET',
]
```

* In yout .env file

```php
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

For more informations about the filters you can use in each methods, refer to the [mailjet API documentation](https://dev.mailjet.com/email-api/v3/apikey/)


## Use the response

Every method use to make a request will return an array like this :

```php
Response {#275 ▼
  -status: 200
  -success: true
  -body: array:3 [▶]
  -rawResponse: Response {#270 ▶}
  +"request": Request {#241 ▶}
}
```

### Body part

The body part of this response will contain :

```php
body: array:3 [▼
    "Count" => 9
    "Data" => array:9 [▶]
    "Total" => 9
]
```

The 'Data' array contains all the informations the mailjet API has returned.

### Rawresponse Part

```php
rawResponse: Response {#270 ▼
    -reasonPhrase: "OK"
    -statusCode: 200
    -headers: array:3 [▶]
    -headerNames: array:3 [▶]
    -protocol: "1.1"
    -stream: Stream {#268 ▶}
}
```

This is the response the server return, it contains the headers etc. but no data

### Request Part

```php
"request": Request {#241 ▼
    -method: "GET"
    -url: "https://api.mailjet.com/v3/REST/contactslist"
    -filters: []
    -body: null
    -auth: array:2 [▶]
    -type: "application/json"
    -config: array:8 [▶]
  }
```

Here, you can see the request that was made to the mailjet API. It can be useful when debugging your app.
