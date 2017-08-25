# Examples


## Retrieve Mailjet Client Object to make custom MailJet API V3 requests

You can retrieve the MailjetClient, as defined in the PHP [wrapper]((https://github.com/mailjet/mailjet-apiv3-php)), with the method getClient() and make your own request to Mailjet API.
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
## Prepare & Send a Campaign Draft

To create a campaign draft, perform a POST on the /campaigndraft . Required fields are a Locale, Sender, SenderEmail, Subject and ContactsListID.
In the providers array inside app.php add:

    Mailjet\LaravelMailjet\Providers\CampaignDraftServiceProvider::class

You can access the [/campaigndraft](https://dev.mailjet.com/email-api/v3/campaigndraft) api through the CampaignDraftContract.
 

Example:

``` php
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
Now that we have a campaign draft, we can add the most important property: its content, which can be Text or Html (Text-part or Html-part).

``` php
    $content = ['Html-part' => "Hello <strong>world</strong>!",
        'Text-part' => "Hello world!"];
    $campaignDraft->setContent($content);
    $campaignDraftManager->createDetailContent($campaignDraft->getId(), $campaignDraft->getContent());

```

Once the campaign draft is completely set up, it can be sent through the CampaignDraftContract.
``` php
     /*     * Send the a campaigndraft** */
    $campaignDraftManager->sendCampaign($campaignDraft->getId());

```

## Storing & Sending a Template
The /template resource allows to store your template on the Mailjet system.
To create a template you need to specify it's name.

You can than reuse the template at will for your messages by referencing the ID returned when created

In the providers array inside app.php add:

    Mailjet\LaravelMailjet\Providers\TemplateServiceProvider::class

You can access the [/template](https://dev.mailjet.com/email-api/v3/template) api through the TemplateContract.

Create Template Example:

``` php
<?php
use Mailjet\LaravelMailjet\Contracts\TemplateContract;
use Mailjet\LaravelMailjet\Model\Template;

// ...
public function templateExample(TemplateContract $templateManager) {
    // ...
        //Example create template
        $optionalProp['Author'] = 'Mailjet team';
        $optionalProp['EditMode'] = 1;
        $optionalProp['Purposes'] = ['transactional'];
        $template = new Template("Laravel Template Example!!! ", $optionalProp);
        
        $ID = $templateManager->create($template)[0]['ID'];
        
        //Add content to a template
        $contentData = [
            'Html-part' => "<html><body><p>Hello {{var:name}}</p></body></html>",
            'Text-part' => "Hello {{var:name}}"
        ];
        $templateManager->createDetailContent($ID, $contentData);
        
        //Example list all templates based on multiple filters
        $filters['OwnerType']='apikey';
        $filters['EditMode']=1;
        $result=$templateManager->getAll($filters);
}
```
To send the template you use the Mj-TemplateID property in your Send API payload to specify the ID of the the template you created.

You must set the Mj-TemplateLanguage property in the payload at true to have the templating language interpreted.

Send Template Example:
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
## Campaigns Example

In the providers array inside app.php add:

    Mailjet\LaravelMailjet\Providers\CampaignServiceProvider::class

You can  access the [/campaign](https://dev.mailjet.com/email-api/v3/campaign) API through the CampaignContract.

Example:

``` php
<?php

use Mailjet\LaravelMailjet\Contracts\CampaignContract;
use Mailjet\LaravelMailjet\Model\Campaign;
    // ...
public function campaignExample(CampaignContract $campaignManager ) {
        // ...
        //Example retrieve all (limit 10 :) ) stared campaigns
        $result = $campaignManager->getAllCampaigns($filters);
}
```
## Change User's email address
In the providers array inside app.php add:

     Mailjet\LaravelMailjet\Providers\ContactsListServiceProvider::class

```php
<?php

use Mailjet\LaravelMailjet\Contracts\ContactsListContract;
use Mailjet\LaravelMailjet\Model\Contact;

public function changeEmailAddress(ContactsListContract $ContactsListManager, $oldEmail, $newEmail,$listId)
{
    // ...
    $contact = new Contact($newEmail);

      $ContactsListManager->updateEmail($listId,$contact,$oldEmail);

}
```