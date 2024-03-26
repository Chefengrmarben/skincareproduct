<?php

//use init.php when not using composer's autoload
//require '/pathtopaymongo/init.php'
//
require 'initialize.php';


// initialize client
$client = new \PaymongoClient('your sercrect API key here');

// error handling
try{
    $client = new \PaymongoClient('invalid secret api key');
    // some paymongo api calls
}catch(\Paymongo\Exceptions\AuthenticationException $e){
    //handle error if api key is invalid
}

try{
    $client = new \Paymongo\PaymongoClient('secret API key');
    $payment = $client->payments->create([
        //incorrect payload
    ]);
}catch (\Paymongo\Exceptions\InvalidRequestException $e){
    //handle error if there's valdation error
    foreach($e->getError() as $error){
        echo $error->code;
        echo $error->detail;
    }
}

//retrieve a payment  method
$newPaymentIntent = $client->paymentIntents->retrieve('insert payment intent id here');

//create a payment intent
$newPaymentIntent =  $client->paymentIntents->create([
    'amount'=>1000,
    //other payload
]);

//retrieve a payment intent
$paymentIntent = $client->paymentIntents->retrieve('insert payment intent id here');

//create source
$source = $client->sources->create([
    //insert payload here
]);

//Verifying webhook sgnature
try{
    $payload = @file_get_contents("php://input");
    $signatureHeader = $_SERVER['HTTP_PAYMONGO_SIGNATURE'];
    $webhookSecretKey = 'your webhook secret key here';

    $event = $client->webhooks->constructEvent([
        'payload' => $payload,
        'signature_header' => $signatureHeader,
        'webhook_secret_key' => $webhookSecretKey
    ]);

    echo $event->id;
    echo $event-type;
    print "<pre>";
    print_r($event->resource);
    print "</pre>"
    die();

}catch (\Paymongo\Exceptions\SignatureVerificationException $e){
    //handle error if webhook signature is not verified
    echo 'invalid siganture';
}

echo $payment->id;