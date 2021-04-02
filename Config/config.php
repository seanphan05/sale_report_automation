<?php 
/** 
* Configuration for database connection
*
*/
$host 		= "sql310.unaux.com";
$username 	= "unaux_26370753";
$password   = "142ac6c";
$dbname     = "unaux_26370753_lottery_db";
$dsn        = "mysql:host=$host; dbname=$dbname";
$options    = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
	);