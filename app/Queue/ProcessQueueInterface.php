<?php

namespace Queue;

interface ProcessQueueInterface {

    public function lockEmailsFromQueue($thisServerName, $maxNum);

    public function getLockedEmails($thisServerName);

    public function updateProcessStatus($thisServerName, $maxNum);

    public function initiateAsyncThread($threadArray, $dataArrayJSON);

}