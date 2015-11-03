<?php

/**
 * Class ProcessQueue
 *
 * This class implements the ProcessQueue Interface and defines processing of the email queue
 *
 * @package Queue
 * @author  Kumar Saurabh Sinha
 * @version 1.0
 *
 */

namespace Queue;

use Database\Database;
use Log\Log;


class ProcessQueue implements ProcessQueueInterface {

    var $objConn;

    /**
     * @param Database $objConn
     */
    public function __construct(Database $objConn) {

        $this->objConn = $objConn;
        $this->objConn->getConnection();

    }

    /**
     * Defines the way to lock the rows from the queue
     * @param $thisServerName
     * @param $maxNum
     *
     * @return bool
     */
    public function lockEmailsFromQueue($thisServerName, $maxNum) {

        $query = "UPDATE email_queue
                            SET status = ?,
                                picked_by = ?
                            WHERE status = ?
                            ORDER BY id ASC
                            LIMIT $maxNum";

        $queryParams = array(2, $thisServerName, 1);

        return $this->objConn->updateData($query, $queryParams);


    }

    /**
     * Defines the way to get the locked rows from the queue table
     * @param $thisServerName
     *
     * @return bool
     */
    public function getLockedEmails($thisServerName) {

        $query = "SELECT * FROM email_queue
                              WHERE status = ?
                                  AND picked_by = ?
                              ORDER BY id ASC";

        $queryParams = array(2, $thisServerName);

        return $this->objConn->getData($query, $queryParams);
    }

    /**
     * Defines the way to update the status of the queue data
     * @param $id
     * @param $thisServerName
     * @param $status
     *
     * @return bool
     */
    public function updateProcessStatus($id, $thisServerName, $status) {

        $query = "UPDATE email_queue
                            SET status = ?
                            WHERE id = ?
                                AND picked_by = ?
                            ";

        $queryParams = array($status, $id, $thisServerName);

        return $this->objConn->updateData($query, $queryParams);

    }

    /**
     * Defines the way to call the async email sending process
     * @param $threadArray
     * @param $dataString
     *
     * @return bool
     */
    public function initiateAsyncThread($threadArray, $dataString) {

        if ($fp = fsockopen($threadArray['protocol'] . $threadArray['host'], $threadArray['port'], $errno, $errstr, $threadArray['timeout']))
        {

            $msg  = "POST " . $threadArray['path'] . " HTTP/1.1\r\n";
            $msg .= "Host: " . $threadArray['host'] . "\r\n";
            $msg .= "User-Agent: " . "async_mailing_thread" . "\r\n";
            $msg .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $msg .= "Content-length: " . strlen($dataString) . "\r\n";
            $msg .= "Connection: close\r\n\r\n";
            $msg .= $dataString . "\r\n\r\n";

            fwrite($fp, $msg);

            fclose($fp);

        }

        Log::writeLog('Async Execution Failed. Please Check Async Configuration', EXCEPTION_PATH);

        return false;

    }

}