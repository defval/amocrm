<?php

use GuzzleHttp\Client;
use mb24dev\AmoCRM\AmoCRMClient;
use mb24dev\AmoCRM\Entity\Company;
use mb24dev\AmoCRM\Entity\CustomField;
use mb24dev\AmoCRM\Entity\Value;
use mb24dev\AmoCRM\Method;
use mb24dev\AmoCRM\ResponseTransformer\StdObjectResponseTransformer;
use mb24dev\AmoCRM\SessionStorage\FileSessionStorage;
use mb24dev\AmoCRM\User\User;

require_once __DIR__ . '/../vendor/autoload.php';

// store strategy for sessions
$fileStorage = new FileSessionStorage('/tmp/amocrm/');

// example guzzle client
$client = new Client();

// response transformer for all methods in this client
$amoCRMClient = new AmoCRMClient($client, $fileStorage, new StdObjectResponseTransformer());

$user = new User('https://mb24dev.amocrm.ru/', 'mb24dev@gmail.com', '66c7fd7f53d583c6096053e1bc1fba38');

// contact set/update
$lead = new Company('testCompany');
$lead->setAmoCustomFields(
    [
        new CustomField(
            '1027582', [
                new Value('mb24dev@gmail.com', 'OTHER'),
                new Value('mb24direct@gmail.com', 'WORK'),
            ]
        ),
    ]
);

$lead->setAmoTags('test');

$leadSet = new Method\CompanySet($user);

$leadSet->setCompany(
    [
        $lead,
    ]
);

$result = $amoCRMClient->exec($leadSet);

echo 'LeadSet result: ' . print_r($result, true);
