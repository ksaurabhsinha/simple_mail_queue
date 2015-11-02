<?php

require_once('bootstrap.php');

use Service as Service;
use Database as Database;

$objDB = new Database\Database($dbCredArray);
$objProcessQueue = new Service\ProcessQueue($objDB);