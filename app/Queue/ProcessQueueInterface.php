<?php

/**
 * Interface ProcessQueueInterface
 *
 * This is the interface for the Queue Processing definition
 *
 * @package Queue
 * @author  Kumar Saurabh Sinha
 * @version 1.0
 *
 *
 */

namespace Queue;

interface ProcessQueueInterface {

    /**
     * Should define the locking mechanism for the rows in the email_queue table
     * @param $thisServerName
     * @param $maxNum
     *
     * @return mixed
     */
    public function lockEmailsFromQueue($thisServerName, $maxNum);

    /**
     * Should define the way to select the locked table for this processing
     * @param $thisServerName
     *
     * @return mixed
     */
    public function getLockedEmails($thisServerName);

    /**
     * Should define the update process for the emails processed
     * @param $id
     * @param $thisServerName
     * @param $status
     *
     * @return mixed
     */
    public function updateProcessStatus($id, $thisServerName, $status);

    /**
     * Should define the Async Process for sending the email
     * @param $threadArray
     * @param $dataArrayJSON
     *
     * @return mixed
     */
    public function initiateAsyncThread($threadArray, $dataArrayJSON);

}