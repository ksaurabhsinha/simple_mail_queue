<?php

//Get the set of required files
require_once('bootstrap.php');

use Queue as Queue;
use Database as Database;

$objDB = new Database\Database($dbCredArray); //Get the DB Object
$objProcessQueue = new Queue\ProcessQueue($objDB); //Process Queue need DB for processing

if($objProcessQueue->lockEmailsFromQueue(SERVER_NAME, MAX_MAILS_TO_READ)) {

    $emailArray = $objProcessQueue->getLockedEmails(SERVER_NAME);

    if(is_array($emailArray) && count($emailArray) > 0) {

        foreach($emailArray as $key=>$sendEmailArray) {

            //Setup the JSON for the Async Process execution
            $asyncParamsJSON = json_encode($sendEmailArray);

            //Initiate the Async Process with the configuration required
            $objProcessQueue->initiateAsyncThread($asyncConfigArray, 'postValue=' . $asyncParamsJSON);

        }

    }
}
