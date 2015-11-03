<?php


/**
 * Class Log
 *
 * This class will be used to log the info to a file
 *
 * @package Log
 * @author  Kumar Saurabh Sinha
 * @version 1.0
 *
 *
 */

namespace Log;

final class Log
{

    public static function writeLog($logArray, $path)
    {

        if (is_object($logArray) || is_array($logArray)) {
            $logString = json_encode($logArray);
        } else
            $logString = $logArray;

        $err = date('Y-m-d H:i:s') . " - " . $logString . PHP_EOL . str_repeat('-', 100) . PHP_EOL . PHP_EOL;
        error_log($err, 3, $path);

    }

}