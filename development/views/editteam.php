<?php
include "autoloader.php";
if ((!isset($_SESSION['username'])))
{
	header('Location: loginpage.php');
}
$username = $_SESSION['username'];
$controller = new generalController();
$teamID = $_GET['id'];
$infoList = $controller->getTeamInfoList($teamID);
$teamName = $controller->getTeamName($teamID);
$teamNumber = $controller->getTeamNumber($teamID);
$categoryNames = $infoList[0];
$categoryContents = $infoList[1];
$infoIDs = $infoList[2];

if (isset($_POST['submit']))
{
	$teamName = $_POST['teamname'];
	$teamNumber = $_POST['teamnumber'];
	$categoryNames = $_POST['categoryname'];
	$categoryContents = $_POST['categorycontent'];
	//print_r($categoryNames);
	//print_r($categoryContents);
	//$teamID = $controller->inputNewTeam($var1, $var2);
	$controller->updateTeam($teamID, $teamName, $teamNumber, $username);
	$finalArray = array();
	for ($i=0; $i < count($categoryNames); $i++)
	{
		if (is_null($infoIDs[$i]))
		{
			$finalArray[] = array(
				"CategoryName" => $categoryNames[$i]["name"],
				"CategoryContent" => $categoryContents[$i]["content"],
				"TeamID" => $teamID
			);
		}
		else
		{
			$finalArray[] = array(
				"CategoryName" => $categoryNames[$i]["name"],
				"CategoryContent" => $categoryContents[$i]["content"],
				"TeamID" => $teamID,
				"TeamInfoID" => $infoIDs[$i]
			);
		}
	}
	$ret = $controller->updateTeamInfo($teamID, $finalArray);
	//print_r($finalArray);
	//print_r($ret);
}
$infoList = $controller->getTeamInfoList($teamID);
$categoryNames = $infoList[0];
$categoryContents = $infoList[1];
$infoIDs = $infoList[2];

//print_r($infoIDs);
//print_r($categoryNames);
//print_r($categoryContents);
if (isset($_POST['cancel']))
{
	header("Location: ../index.php");
	//exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
	<title>Harker Robotics 1072 Scouting App - Edit Team</title> 
	
	<!-- jQuery Mobile -->
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
	
	<!-- viewport -->
	<meta name="viewport" content="width=device-width">

	<!-- iOS stuff -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="white">

	<!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
	<meta http-equiv="cleartype" content="on">

	<!-- For mobile browsers that do not recognize the viewport tag -->
	<meta name="MobileOptimized" content="320" />
	
	<script type="text/javascript" charset="utf-8">
		function add() {
			//alert("alert");
			$('#categories').append('<fieldset class="ui-grid-a"><label for="categoryname">Category Name:</label><input type="text" name="categoryname[][name]" id="categoryname" value="" placeholder="Category Name"/><label for="categorycontent">Notes:</label><textarea name="categorycontent[][content]" id="categorycontent" value="" placeholder="Notes"></textarea></fieldset>');
			//location.reload();
		}
		function reload() {
			location.reload();
		}
	</script>
</head>

<body>
	
	<div data-role="page" id="editteam">
		
		<header data-role="header" data-theme="a">
			<h1>Edit Team</h1>
		</header>
		
		<div data-role="content">
			<form action="editteam.php?id=<?php echo $teamID; ?>" method="post">
				<div class="ui-hide-label">
					<fieldset class="ui-grid-a">
						<label for="teamname">Team Name:</label>
						<?php echo '<input type="text" name="teamname" id="teamname" value="'. $teamName .'" placeholder="Team Name"/>'; ?>
						<label for="teamnumber">Team Number:</label>
						<?php echo '<input type="text" name="teamnumber" id="teamnumber" value="'.$teamNumber  .'" placeholder="Team Number"/>'; ?>
					</fieldset>
				</div><!-- end teamname teamnumber div -->
				<div class="ui-hide-label" id="categories">
					<?php
					for ($i=0; $i < count($categoryNames); $i++)
					{
						echo '<fieldset class="ui-grid-a"><label for="categoryname">Category Name:</label><input type="text" name="categoryname['.$i.'][name]" id="categoryname" value="'.$categoryNames[$i].'" placeholder="Category Name"/><label for="categorycontent">Notes:</label><textarea name="categorycontent['.$i.'][content]" id="categorycontent" value="" placeholder="Notes">'.$categoryContents[$i].'</textarea></fieldset>';
					}
					?>
				</div><!-- end category div -->
				<!-- <input type="button" name="addcategory" value="+" id="button" onClick="add();" /> -->
				<div class="ui-body ui-body-b">
					<fieldset class="ui-grid-a">
						<div class="ui-block-a"><input type="submit" data-theme="c" name="cancel" data-ajax="false" data-direction="reverse" value="Cancel" /></div>
						<div class="ui-block-b"><input type="submit" data-theme="b" name="submit" data-ajax="false" data-direction="reverse" value="Submit" /></div>
					</fieldset>
				</div><!-- end submission div -->
			</form>
		</div><!-- end content div -->
		
		<footer data-role="footer" data-theme="a">
			<div class="footer-nav" data-role="navbar" data-iconpos="top">
				<ul>
					<li><a href="index.php?" id="home-button" data-icon="home" data-transition="slide" data-direction="reverse" data-ajax="false">Home</a></li>
					<li><a href="addnewteam.php?" id="addnewteam-button" data-icon="plus" data-transition="slide" data-ajax="false">Add</a></li>
				</ul>
			</div><!-- end navbar -->
		</footer>
		
	</div><!-- end page div -->
	
</body>
</html>