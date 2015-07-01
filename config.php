<?php

	session_start();
	
	include('lib/php/functions.php');
	
	date_default_timezone_set('Europe/Amsterdam'); 
	
	define(HOST, ''); //Insert database host
	define(USERNAME, ''); //Insert database username
	define(PASSWORD, ''); //Insert database password
	define(DB_NAME, ''); //Insert database name
	
	define(ROOT, 'http://www.'); //Insert root of your knowledge portal
	
	$db = mysql_connect(HOST,USERNAME,PASSWORD); 
 	if (!$db) {
	 	die("Can't connect to database: " . mysql_error());
	}
	 
	if (!mysql_select_db(DB_NAME)) {
    	echo "Unable to select mydbname: " . mysql_error();
    	exit;
	}

?>