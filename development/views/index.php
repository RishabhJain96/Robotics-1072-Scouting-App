<?php
include "autoloader.php";
if ((!isset($_SESSION['username'])))
{
	header('Location: loginpage.php');
}
//if(isset($_POST['logout']))
//{
//	unset($_SESSION['username']);
//	header('Location: loginpage.php');
//	//exit;
//}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
	<title>Harker Robotics 1072 Scouting App - Home</title> 
	
	<!-- jQuery Mobile -->
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
	
	<!-- custom scripts -->
	<script type="text/javascript" src="functions.js"></script>
	
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
			$.post("../apis/read.php?action=getteamnames", function(data) {
				$("#teamlist").html(data);
			}, "html");
		</script> -->
	<!-- <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				//location.reload();
				$.post("../apis/read.php?action=getteamnames", function(data) {
					//alert("data" + data);
					$("#teamlist").html(data);
				}, "html");
				//$("#teamlist").show("fast");
			});
		</script> -->
</head>

<body>
	
	<div data-role="page" id="home">
		
		<header data-role="header" data-theme="a" data-position="inline">
			<h1>Teams</h1>
			<!-- <a href="controllers/logout.php" class="ui-btn-right">Logout: <?php //echo $_SESSION['username']; ?></a> -->
		</header>
		
		<div data-role="content">
			<ul data-role="listview" data-inset="false" id="teamlist">
				<?php
				$controller = new generalController();
				$aNames = $controller->getAllTeamNames();
				$ids = $controller->getAllTeamIds();
				for ($i=0; $i < count($aNames); $i++)
				{ 
					echo "<li><a data-ajax=\"false\" href=\"editteam.php?id=".$ids[$i]."\">".$aNames[$i]."</a></li>\n";
				}
				?>
			</ul>
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