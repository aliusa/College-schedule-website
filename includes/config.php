<?php
ob_start();
session_start();

// db properties
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','vkk_schedule');

// make a connection to mysql here
$conn = @mysql_connect (DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db (DBNAME);
if(!$conn){
	die( "Sorry! There seems to be a problem connecting to our database.");
}

$dir = 'http://'.$_SERVER['SERVER_NAME'].''.substr($_SERVER['PHP_SELF'], 0, -10);

// define site path
define('DIR', $dir);

// define admin site path
define('DIRADMIN', $dir.'/');

// define site title for top of the browser
define('SITETITLE','VKK Paskaitų tvarkaraštis');

//define include checker
define('included', 1);

include('functions.php');

//connect to Database with PDO
try {
	$pdo = new PDO('mysql:host=localhost;dbname=vkk_schedule;charset=utf8', 'root', '');
} catch (PDOExeption $e) {
	exit('Database error.');
}

?>