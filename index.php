<?php

require_once('bootstrap.php');

use Queue as Queue;
use Database as Database;

$objDB = new Database\Database($dbCredArray); //Get the DB Object
$objProcessQueue = new Queue\ProcessQueue($objDB); //Process Queue need DB for processing

