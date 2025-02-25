# Examples

## Prepare & Send a Campaign Draft

In order to create a draft campaign, perform a `POST` on the `/campaigndraft` endpoint.

Required fields are `Locale`, `Sender`, `SenderEmail`, `Subject` and `ContactsListID`.
In the providers array inside `app.php` add:

    Mailjet\LaravelMailjet\Providers\CampaignDraftServiceProvider::class

You can manage [/campaigndraft](https://dev.mailjet.com/email-api/v3/campaigndraft) resources using the `CampaignDraftContract` class.


### Code sample

```php
<?php
use Mailjet\LaravelMailjet\Contracts\CampaignDraftContract;
use Mailjet\LaravelMailjet\Model\CampaignDraft;
// ...
public function campaignDraftExample(CampaignDraftContract $campaignDraftManager ) {
    // ...
    $optionalProp['Title'] = 'Friday newsletter';
    $optionalProp['SenderName'] = 'Mailjet team';
    $optionalProp['EditMode'] = 'html2';
    $campaignDraft = new CampaignDraft("en_US", "Lyubo", "api@mailjet.com", "Laravel bundle test", "5410");
    $campaignDraft->setOptionalProperties($optionalProp);
    $campaignDraftManager->create($campaignDraft);
}
```

Now we've created a draft campaign, we can set its most important property: the content, which can be either plain text or HTML (respectively represented by the `Text-part` and the `Html-part` resource's properties).

```php
    $content = ['Html-part' => "Hello <strong>world</strong>!",
        'Text-part' => "Hello world!"];
    $campaignDraft->setContent($content);
    $campaignDraftManager->createDetailContent($campaignDraft->getId(), $campaignDraft->getContent());
```

Once the draft campaign draft is all set, it can now be sent via the `CampaignDraftContract`.
``` php
     /* Send the campaigndraft instance */
    $campaignDraftManager->sendCampaign($campaignDraft->getId());

```

## Storing & Sending a Template
The `/template` resource allows to store your template on the Mailjet system.
To create a template you only need to provide a name.

You can than reuse the template in your messages by referencing the ID returned when created.

In the providers array inside `app.php` add:

    Mailjet\LaravelMailjet\Providers\TemplateServiceProvider::class

You can manage [/template](https://dev.mailjet.com/email-api/v3/template) resources through the `TemplateContract`.

### Create Template Code Sample

```php
<?php
use Mailjet\LaravelMailjet\Contracts\TemplateContract;
use Mailjet\LaravelMailjet\Model\Template;

// ...
public function templateExample(TemplateContract $templateManager) {
        $optionalProp['Author'] = 'Mailjet team';
        $optionalProp['EditMode'] = 1;
        $optionalProp['Purposes'] = ['transactional'];
        $template = new Template("Laravel Template Example", $optionalProp);

        $ID = $templateManager->create($template)[0]['ID'];

        // Set template content
        $contentData = [
            'Html-part' => "<html><body><p>Hello {{var:name}}</p></body></html>",
            'Text-part' => "Hello {{var:name}}"
        ];
        $templateManager->createDetailContent($ID, $contentData);

        // List all templates based on multiple filters
        $filters['OwnerType']='apikey';
        $filters['EditMode']=1;
        $result=$templateManager->getAll($filters);
}
```

To send the template you must set the `Mj-TemplateID` property to the template ID to send in your Send API payload.

In addition to that, you must set the `Mj-TemplateLanguage` property in the Send API payload to true in order to have the Mailjet templating language interpreted.

### Send Template Code Sample

``` php
<?php
    use \Mailjet\Resources;
    use Mailjet\LaravelMailjet\Facades\Mailjet;
    ...
    $mj = Mailjet::getClient();
    $body = [
    'FromEmail' => "pilot@mailjet.com",
    'FromName' => "Mailjet Pilot",
    'Subject' => "Your email flight plan!",
    'MJ-TemplateID' => $ID,
    'MJ-TemplateLanguage' => true,
    'Recipients' => [['Email' => "passenger@mailjet.com"]]
];
$response =  $mj->post(Resources::$Email, ['body' => $body]);
$response->success() && var_dump($response->getData());
```

## Manage Campaigns

In the providers array inside `app.php` add:

    Mailjet\LaravelMailjet\Providers\CampaignServiceProvider::class

You can manage the [/campaign](https://dev.mailjet.com/email-api/v3/campaign) resources through the `CampaignContract`.

### Code Sample

```php
<?php

use Mailjet\LaravelMailjet\Contracts\CampaignContract;
use Mailjet\LaravelMailjet\Model\Campaign;
    // ...
public function campaignExample(CampaignContract $campaignManager ) {
        // Retrieve last ten starred campaigns
        $result = $campaignManager->getAllCampaigns($filters);
}
```
## Update a contact email address
In the providers array inside app.php add:

     Mailjet\LaravelMailjet\Providers\ContactsListServiceProvider::class

```php
<?php

use Mailjet\LaravelMailjet\Contracts\ContactsListContract;
use Mailjet\LaravelMailjet\Model\Contact;

public function changeEmailAddress(ContactsListContract $ContactsListManager, $oldEmail, $newEmail, $listId)
{
    $contact = new Contact($newEmail);

    $ContactsListManager->updateEmail($listId, $contact,$oldEmail);
}
```

## Retrieve Mailjet Client instance to perform custom requests

You can retrieve the `MailjetClient` instance, as defined in the PHP [wrapper]((https://github.com/mailjet/mailjet-apiv3-php)), using the method `getClient()`. It enables you to perform custom requests to Mailjet API.

* In the providers array

```php
'providers' => [
    ...
    Mailjet\LaravelMailjet\MailjetServiceProvider::class,
    Mailjet\LaravelMailjet\MailjetMailServiceProvider::class,
    ...
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
To use it, you need to import Mailjet Facade in your file

    use Mailjet\LaravelMailjet\Facades\Mailjet;

Example:

``` php
<?php
    use \Mailjet\Resources;
    use Mailjet\LaravelMailjet\Facades\Mailjet;

    ...
    $mailjet = Mailjet::getClient();

    // Resources are all located in the Resources class
    $response = $mailjet->get(Resources::$Contact);

    /*
      Read the response
    */
    if ($response->success())
      var_dump($response->getData());
    else
      var_dump($response->getStatus());

    ...
    // Send transactional emails (note: prefer using SwiftMailer to send transactionnal emails)

    $body = [
        'FromEmail' => "pilot@mailjet.com",
        'FromName' => "Mailjet Pilot",
        'Subject' => "Your email flight plan!",
        'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
        'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br />May the delivery force be with you!",
        'Recipients' => [['Email' => "passenger@mailjet.com"]]
    ];

    $response = $mailjet->post(Resources::$Email, ['body' => $body]);

```

## Usage with Laravel Mailable class
In order to use this package with a laravel `Mailable` class, first generate a `Mailable` class:
```bash
php artisan make:mail InvoicePaid
```
Then define mailjet `X-MJ-` or `X-Mailjet-` properties inside the `headers` method, these headers will be add to the message body before sending.

### InvoicePaid class
```php
<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;

class InvoicePaid extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $invoiceNumber
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Variables can be use in subject too
            subject: 'Invoice Paid {{var:invoiceNumber}}',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.invoice-paid',
            text: 'mail.invoice-paid-text'
        );
    }

    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-MJ-TemplateLanguage' => true, // must be set to true to use variables
                // Full list
                'X-MJ-Vars' => json_encode([
                    'invoiceNumber' => $this->invoiceNumber
                ]),
                'X-MJ-TemplateID' => 12532,
                'X-MJ-TemplateErrorReporting' => json_encode([...]),
                'X-MJ-TemplateErrorDeliver' => true,
                'X-MJ-CustomID' => 'string',
                'X-MJ-EventPayload' => 'string',
                'X-Mailjet-Campaign' => 'string',
                'X-Mailjet-DeduplicateCampaign' => true,
                'X-Mailjet-Prio' => 5,
                'X-Mailjet-TrackClick' => 'string',
                'X-Mailjet-TrackOpen' => 'string',
            ]
        );
    }
}
```

### Views
Use `@` to escape blade directive.
In `views/mail.invoice-paid.blade.php`:
```php
<p>An invoice has been paid: @{{var:invoiceNumber}}</p>
```

In `views/mail.invoice-paid-text.blade.php`:
```php
An invoice has been paid: @{{var:invoiceNumber}}
```

### Example with mailjet template
```php
<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;

class InvoicePaid extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $invoiceNumber
    ) {
        // Set empty HTML since a tempalte is used
        $this->html('');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Variables can be use in subject too
            subject: 'Invoice Paid {{var:invoiceNumber}}',
        );
    }

    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-MJ-TemplateLanguage' => true,
                'X-MJ-Vars' => json_encode([
                    'invoiceNumber' => $this->invoiceNumber
                ]),
                'X-MJ-TemplateID' => 12532,
            ]
        );
    }
}
```
