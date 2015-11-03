<?php

//Set the default timestamp for the application
date_default_timezone_set("UTC");

//Get the configuration file
require_once('config.php');

//autoload the APP classes
require_once('app/Autoloader.php');

//autoload the Vendor packages
require_once('vendor/autoload.php');