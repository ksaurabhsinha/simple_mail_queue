<?php

namespace Service;

interface ProcessQueueInterface {

    public function lockEmailsFromQueue($thisServerName, $maxNum);

    public function getLockedEmails($thisServerName);

    public function updateProcessStatus($thisServerName);

}