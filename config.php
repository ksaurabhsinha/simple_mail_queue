<?php

//Define the Server name. This would be different for every different server
define('SERVER_NAME', 'web01');

/** ************** Start: SMTP Credentials *************** */

define('SMTP_HOST', 'mailtrap.io');
define('SMTP_PORT', 25);    //change if required
define('SMTP_USER', 'YOUR_USER_NAME_HERE');
define('SMTP_PASSWORD', 'YOUR_PASSWORD_HERE');
define('SMTP_PROTOCOL', 'tls'); //ssl OR tls is required

/** ************** End: SMTP Credentials *************** */

//This defines the number of emails to read for every execution cycle
define('MAX_MAILS_TO_READ', 2);

/** ************* Start: Database Credentials **************** */

$dbCredArray = array('hostname' => 'localhost',
                    'port' => 3306,
                    'username' => 'root',
                    'password' => 'rootroot',
                    'charset' => 'utf8',
                    'dbname' => 'mail_queue_db');

/** ************* End: Database Credentials **************** */

/** *************** Start: Async Configuration **************** */

$asyncConfigArray = array('protocol' => '', // ssl:// for https
                        'port' => 80,   // 443 for https
                        'host' => 'local.mailqueue',    //host name
                        'path' => '/async_send_mail.php',   //file path in accordance to the hostname
                        'timeout' => 30);   //timeout for the async task

/** *************** End: Async Configuration **************** */

/** ************* Start: Log Path ***************** */

define('LOG_PATH', __DIR__ . '/applogs/');     //Path to the Logs

define('EXCEPTION_PATH', LOG_PATH . 'app_error.log');   //Application Exceptions
define('MAIL_ERROR', LOG_PATH . 'mail_error.log');      //Mail Errors

/** ************* Write: Log Path ***************** */