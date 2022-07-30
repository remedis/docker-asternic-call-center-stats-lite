<?php
require_once("dblib.php");
require_once("misc.php");

$queue_log_dir  = '/var/log/asterisk/';
$queue_log_file = 'queue_log';

$dbhost = getenv('dbhost');
$dbname = getenv('dbname');
$dbuser = getenv('dbuser');
$dbpass = getenv('dbpass');

$midb = new dbcon($dbhost, $dbuser, $dbpass, $dbname, true);
$self = $_SERVER['PHP_SELF'];

$DB_DEBUG = false;

?>
