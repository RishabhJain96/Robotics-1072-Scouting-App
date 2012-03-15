<?php
include "autoloader.php";

$controller = new generalController();
$result = "";

// get all parameters
$action = $_GET['action']; // possible vals: 'getteamnames', 'getteamnumbers', 'getteaminfolist'

if ($action == "getteamnames")
{
	$aNames = $controller->getAllTeamNames();
	$ids = $controller->getAllTeamIds();
	//$result = "<ul data-role=\"listview\" data-inset=\"false\">\n";
	for ($i=0; $i < count($aNames); $i++)
	{ 
		$result .= "<li><a href=\"editteam.php?id=".$ids[$i]."\">".$aNames[$i]."</a></li>\n";
	}
	//$result .= "</ul>\n";
}
else if ($action == "getteamnumbers")
{
	$aNumbers = $controller->getAllTeamNumbers();
	$ids = $controller->getAllTeamIds();
	//$result = "<ul data-role=\"listview\" data-inset=\"false\">\n";
	for ($i=0; $i < count($aNumbers); $i++)
	{
		$result .= "<li><a href=\"editteam.php?id=".$ids[$i]."\">".$aNumbers[$i]."</a></li>\n";
	}
	//$result .= "</ul>\n";
}
else if ($action == "getteaminfolist")
{
	
}
else
{
	$result = "An error occured.";
}

echo $result;
?>