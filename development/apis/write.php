<?php
include "autoloader.php";

$controller = new generalController();
$result = "";

// get all parameters
$action = $_POST['action']; // possible vals: 'inputteam', 'inputteaminfo', 'updateteaminfo'
$teamName = $_POST['teamname'];
$teamNumber = $_POST['teamnumber'];
//$username = $_GET['username'];

if ($action == "inputteam")
{
	$controller->inputNewTeam($teamName, $teamNumber);
}
else if ($action == "inputteaminfo")
{
	
}
else if ($action == "updateteaminfo")
{
	
}
else
{
	$result = "An error occured.";
}

echo $result;
?>