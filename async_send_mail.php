<?php

require_once('bootstrap.php');

use Queue as Queue;
use Database as Database;

if(isset($_POST['postValue'])) {

    //Get the post Array to process
    $dataArray = json_decode($_POST['postValue'], true);

    //Create the Connection
    $objSwiftTransport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_PROTOCOL)
        ->setUsername(SMTP_USER)
        ->setPassword(SMTP_PASSWORD);

    //Setup the Mailer Instance
    $objSwiftMailer = Swift_Mailer::newInstance($objSwiftTransport);

    //Create this Message
    $message = Swift_Message::newInstance($dataArray['subject'])
        ->setFrom(array($dataArray['from_email_address']))
        ->setTo(array($dataArray['to_email_address']))
        ->setBody($dataArray['body'], 'multipart/alternative')
        ->addPart($dataArray['body'], 'text/html')
        ->addPart($dataArray['body'], 'text/plain');
    ;


    $objDB = new Database\Database($dbCredArray); //Get the DB Object
    $objProcessQueue = new Queue\ProcessQueue($objDB); //Process Queue need DB for processing

    // Send the message
    if($objSwiftMailer->send($message)) {

        $updateStatus = $objProcessQueue->updateProcessStatus($dataArray['id'], SERVER_NAME, 3);

    }
    else{
        $updateStatus = $objProcessQueue->updateProcessStatus($dataArray['id'], SERVER_NAME, 4);
    }





}

