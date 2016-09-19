<?php

use GuzzleHttp\Client;
use mb24dev\AmoCRM\AmoCRMClient;
use mb24dev\AmoCRM\Method\CurrentAccount;
use mb24dev\AmoCRM\ResponseTransformer\ArrayResponseTransformer;
use mb24dev\AmoCRM\ResponseTransformer\StdObjectResponseTransformer;
use mb24dev\AmoCRM\SessionStorage\FileSessionStorage;
use mb24dev\AmoCRM\User\User;

require_once __DIR__ . '/../vendor/autoload.php';

// store strategy for sessions
$fileStorage = new FileSessionStorage(__DIR__ . '/../var/sessions/');

// example guzzle client
$client = new Client();

// response transformer for all methods in this client
$amoCRMClient = new AmoCRMClient($client, $fileStorage, new StdObjectResponseTransformer());

$user = new User('https://new5603ee4a9f1a7.amocrm.ru/', 'mb24dev@gmail.com', '66c7fd7f53d583c6096053e1bc1fba38');

// this transformer have more priority than client transformer
// you may create unique transformer for every method. Example transformation response into DTO or another entity
$result = $amoCRMClient->exec(
    new CurrentAccount($user, new ArrayResponseTransformer())
);

var_dump($result);