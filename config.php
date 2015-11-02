<?php

//Define the Server name. This would be different for every different server
define('SERVER_NAME', 'web01');

/** ************** Start: SMTP Credentials *************** */
define('SMTP_HOST', '');
define('SMTP_PORT', '');
define('SMTP_USER', '');
define('SMTP_PASSWORD', '');
/** ************** End: SMTP Credentials *************** */

//This defines the number of emails to read for every execution cycle
define('MAX_MAILS_TO_READ', 10);

/** ************* Start: Database Credentials **************** */

$dbCredArray = array('hostname' => 'localhost',
                    'port' => 3306,
                    'username' => 'root',
                    'password' => 'rootroot',
                    'charset' => 'utf8',
                    'dbname' => 'mail_queue_db');

/** ************* End: Database Credentials **************** */