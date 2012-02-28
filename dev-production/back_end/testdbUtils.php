<?php
include "autoloader.php";
//$dbConnection = dbUtils::getConnection();
$db_name = "testDB";
$dbConfig = dbUtils::getPropertiesConnection();
	
$dbConfig->createDatabase($db_name);

?>