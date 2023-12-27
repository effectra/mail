<?php

use Effectra\Mail\Components\Address;
use Effectra\Mail\Inbox;
use Effectra\Mail\Mail;
use Effectra\Mail\Services\PHPMailerService;

require  __DIR__ . '/../vendor/autoload.php';

$m = new Mail();

$m->addTo(new Address("info@mohammedtaha.com","bmt"));


// [
//     'bmt' =>"info@mohammedtaha.com",
//     'taha' =>"taha@mohammedtaha.com",
// ]

var_dump($m->getTo());