# Laravel Mailjet

This library provide a wrapper arounr MailJet API for laravel. It is still in developpement, don't hesitate to add some method to the services.

## Installation

First, include the package in your dependencies

    require

Then, you need to add some informations in your configuration files

* In the providers array

    `laravelMailjet\MailJetProvider::class,`

* In the aliases array

    `'Mailjet' => laravelMailjet\Facades\Mailjet::class,`

* In the services.php file

    `'mailjet' => [
        'key' => 'YOUT_API_KEY',
        'secret' => 'YOUR_API_SECRET',
    ]`


## Utilisation

To use it, you need to use mailjetFacade in your file

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
