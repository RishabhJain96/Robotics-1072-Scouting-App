<?php
include "autoloader.php";

$controller = new generalController();
$result = "";

// get all parameters
$action = $_POST['action']; // possible vals: 'getteamnames', 'getteamnumbers', 'getteaminfolist'

if ($action == "getteamnames")
{
	
}
else if ($action == "getteamnumbers")
{
	
}
else if ($action == "getteaminfolist")
{
	
}
else
{
	
}

echo $result;
?>