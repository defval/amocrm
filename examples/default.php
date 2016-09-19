<?php

use GuzzleHttp\Client;
use mb24dev\AmoCRM\AmoCRMClient;
use mb24dev\AmoCRM\Entity\Contact;
use mb24dev\AmoCRM\Entity\CustomField;
use mb24dev\AmoCRM\Entity\Value;
use mb24dev\AmoCRM\Method;
use mb24dev\AmoCRM\ResponseTransformer\ArrayResponseTransformer;
use mb24dev\AmoCRM\ResponseTransformer\StdObjectResponseTransformer;
use mb24dev\AmoCRM\SessionStorage\FileSessionStorage;
use mb24dev\AmoCRM\User\User;

require_once __DIR__ . '/../vendor/autoload.php';

// store strategy for sessions
$fileStorage = new FileSessionStorage(__DIR__ . '/../var/');

// example guzzle client
$client = new Client();

// response transformer for all methods in this client
$amoCRMClient = new AmoCRMClient($client, $fileStorage, new StdObjectResponseTransformer());

$user = new User('https://mb24dev.amocrm.ru/', 'mb24dev@gmail.com', '66c7fd7f53d583c6096053e1bc1fba38');

// this transformer have more priority than client transformer
// you may create unique transformer for every method. Example transformation response into DTO or another entity
$result = $amoCRMClient->exec(
    new Method\CurrentAccount($user, new ArrayResponseTransformer())
);

// contact set/update
$contact = new Contact("Test name");
$contact->setAmoCustomFields(
    [
        new CustomField('1027582', [
            new Value('mb24dev@gmail.com', 'OTHER'),
            new Value('mb24direct@gmail.com', 'WORK')
        ])
    ]
);
$contactSet = new Method\ContactSet($user);

$contactSet->setContacts(
    [
        $contact,
        new Contact("Test name 2")
    ]
);

$result = $amoCRMClient->exec($contactSet);
