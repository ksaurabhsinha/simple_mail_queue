<?php

namespace Queue;

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

        return $this->objConn->updateData($query, $queryParams);


    }

    public function getLockedEmails($thisServerName) {

        $query = "SELECT * FROM mail_queue
                              WHERE status = ?
                                  AND picked_by = ?
                              ORDER BY id ASC";

        $queryParams = array(2, $thisServerName);

        return $this->objConn->getData($query, $queryParams);
    }

    public function updateProcessStatus($thisServerName, $maxNum) {

        $query = "UPDATE email_queue
                            SET status = ?
                            WHERE status = ?
                                AND picked_by = ?
                            ORDER BY id ASC
                            LIMIT 0, $maxNum";

        $queryParams = array(3, 2, $thisServerName);

        return $this->objConn->updateData($query, $queryParams);

    }

    public function initiateAsyncThread($threadArray, $dataArrayJSON) {

        if ($fp = fsockopen($threadArray['protocol'] . $threadArray['host'], $threadArray['port'], $errno, $errstr, $threadArray['timeout']))
        {
            $msg  = "POST " . $threadArray['path'] . " HTTP/1.1\r\n";
            $msg .= "Host: " . $threadArray['host'] . "\r\n";
            $msg .= "User-Agent: " . "async_mailing_thread" . "\r\n";
            $msg .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $msg .= "Content-length: " . strlen($dataArrayJSON) . "\r\n";
            $msg .= "Connection: close\r\n\r\n";
            $msg .= $dataArrayJSON . "\r\n\r\n";

            fwrite($fp, $msg);

            fclose($fp);

            return true;

        }

        return false;

    }

}