<?php

namespace Service;

use Database\Database;

class ProcessQueue implements ProcessQueueInterface {

    var $objConn;

    public function __construct(Database $objConn) {

        $this->objConn = $objConn;
        $this->objConn->getConnection();

    }

    public function lockEmailsFromQueue($thisServerName, $maxNum) {

        $query = "UPDATE email_queue
                            SET status = ?,
                                picked_by = ?
                            WHERE status = ?
                            ORDER BY id ASC
                            LIMIT 0, $maxNum";

        $queryParams = array(2, $thisServerName, 1);

        $this->objConn->updateData($query, $queryParams);


    }

    public function getLockedEmails($thisServerName) {

    }

    public function updateProcessStatus($thisServerName) {

    }

}