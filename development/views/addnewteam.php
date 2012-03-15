<?php
include "autoloader.php";
if ((!isset($_SESSION['username'])))
{
	header('Location: loginpage.php');
}
$username = $_SESSION['username'];
$controller = new generalController();
if (isset($_POST['submit']))
{
	$teamName = $_POST['teamname'];
	$teamNumber = $_POST['teamnumber'];
	$categoryNames = $_POST['categoryname'];
	$categoryContents = $_POST['categorycontent'];
	//print_r($categoryNames);
	//print_r($categoryContents);
	//$teamID = $controller->inputNewTeam($var1, $var2);
	$teamID = $controller->inputNewTeam($teamName, $teamNumber);
	$finalArray = array();
	for ($i=0; $i < count($categoryNames); $i++)
	{ 
		$finalArray[] = array(
			"CategoryName" => $categoryNames[$i]["name"],
			"CategoryContent" => $categoryContents[$i]["content"],
			"TeamID" => $teamID
		);
	}
	$controller->inputNewTeamInfo($teamID, $finalArray);
}
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
	
	<title>Harker Robotics 1072 Scouting App - Add Team</title> 
	
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
	
	<!-- <script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("#submitnewteam").click(function(e) {
				e.preventDefault();
				upload();
			});
		});
		
		function upload() {
			var teamname = $("#teamname").val();
			var teamnumber = $("#teamnumber").val();
			$.post("../apis/write.php", { action: "inputteam", teamname: , teamnumber:  }, function(data) {
				alert("Success!" + teamname + teamnumber);
			});
		}
	</script> -->
	<!-- <script type="text/javascript" charset="utf-8">
			function add() {
				document.getElementById('categories').innerHTML += '<fieldset class="ui-grid-a"><label for="categoryname">Category Name:</label><input type="text" name="categoryname[]" id="categoryname" value="" placeholder="Category Name"/><label for="categorycontent">Notes:</label><textarea name="categorycontent[]" id="categorycontent" value="" placeholder="Notes"></textarea></fieldset>';
			}
		</script> -->
	<!-- <script type="text/javascript">
			$(document).ready(function(){
			  $("#button").click(function(){
				  alert("alert");
		  		$('#categories').append('<fieldset class="ui-grid-a">
		  						<label for="categoryname">Category Name:</label>
		  						<input type="text" name="categoryname[]" id="categoryname" value="" placeholder="Category Name"/>
		  						<label for="categorycontent">Notes:</label>
		  						<textarea name="categorycontent[]" id="categorycontent" value="" placeholder="Notes"></textarea>
		  					</fieldset>');
			  });
			});
		</script> -->
	<script type="text/javascript" charset="utf-8">
		var count = 0;
		function add() {
			//alert("alert");
			count++;
			$('#categories').append('<fieldset class="ui-grid-a"><label for="categoryname">Category Name:</label><input type="text" name="categoryname[' + count + '][name]" id="categoryname" value="" placeholder="Category Name"/><label for="categorycontent">Notes:</label><textarea name="categorycontent[' + count + '][content]" id="categorycontent" value="" placeholder="Notes"></textarea></fieldset>');
			//location.reload();
		}
		</script>
</head>

<body>
	<div date-role="page" id="addnewteam">
		
		<header data-role="header" data-theme="a">
			<h1>Add New Team</h1>
		</header>
		
		<div data-role="content">
			<form action="" method="post">
				<div class="ui-hide-label">
					<fieldset class="ui-grid-a">
						<label for="teamname">Team Name:</label>
						<input type="text" name="teamname" id="teamname" value="" placeholder="Team Name"/>
						<label for="teamnumber">Team Number:</label>
						<input type="text" name="teamnumber" id="teamnumber" value="" placeholder="Team Number"/>
					</fieldset>
				</div><!-- end teamname teamnumber div -->
				<div class="ui-hide-label" id="categories">
					<fieldset class="ui-grid-a">
						<label for="categoryname">Category Name:</label>
						<input type="text" name="categoryname[0][name]" id="categoryname" value="" placeholder="Category Name"/>
						<label for="categorycontent">Notes:</label>
						<textarea name="categorycontent[0][content]" id="categorycontent" value="" placeholder="Notes"></textarea>
					</fieldset>
				</div><!-- end category div -->
				<!-- <form name="addcategoryform"> -->
					<input type="button" name="addcategory" value="+" id="button" onClick="add();" />
				<!-- </form> -->
				<div class="ui-body ui-body-b">
					<fieldset class="ui-grid-a">
						<div class="ui-block-a"><input type="submit" data-ajax="false" data-theme="c" name="cancel" data-direction="reverse" value="Cancel" /></div>
						<div class="ui-block-b"><input type="submit" data-ajax="false" data-theme="b" name="submit" data-direction="reverse" value="Submit" /></div>
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