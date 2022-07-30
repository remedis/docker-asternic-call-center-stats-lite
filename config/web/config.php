<?php
require_once("dblib.php");
require_once("misc.php");

// Credentials for MYSQL database
$dbhost = getenv('dbhost');
$dbname = getenv('dbname');
$dbuser = getenv('dbuser');
$dbpass = getenv('dbpass');

// Credentials for AMI (for the realtime tab to work)
// See /etc/asterisk/manager.conf

$manager_host   = getenv('manager_host');
$manager_user   = getenv('manager_user');
$manager_secret = getenv('manager_pass');

// Available languages "es", "en", "ru", "de", "fr"
$language = "en";

require_once("lang/$language.php");

$midb = new dbcon($dbhost, $dbuser, $dbpass, $dbname, true);

$self = $_SERVER['PHP_SELF'];

$DB_DEBUG = false; 

session_start();
//session_register("QSTATS");
header('content-type: text/html; charset: utf-8'); 

?>
