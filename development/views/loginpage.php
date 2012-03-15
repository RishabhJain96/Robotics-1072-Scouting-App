<?php
include "autoloader.php";
if ((isset($_SESSION['username'])))
{
	header('Location: index.php');
}
global $result; // global definition of result
if(isset($_POST['login']))
{
	if(isset($_POST['pwd']))
	{
		if(isset($_POST['username']))
		{
			$password = ($_POST['pwd']);
			$username = $_POST['username'];
			$login = new login();
			global $result; // allows $results to be used later in script
			$result = $login->checkLogin($username, $password);
			if(!is_string($result))
			{
				if (empty($username) || is_null($username))
				{
					$_SESSION['username'] = "null";
				}
				$_SESSION['username'] = "$username";
				header('Location: index.php?id=lol');
				//exit;
			}
		}
	}
}

echo '<!doctype html>';
echo '<head>';
echo '	<meta charset="utf-8">';
echo '	<title>Robotics 1072 Scouting App Login</title>';
echo '	<meta name="description" content="">';
echo '	<meta name="author" content="">';
//echo '	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">';
//echo '  <link rel="stylesheet" type="text/css" href="reset.css">';
echo '<!-- jQuery Mobile -->
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
	<meta name="MobileOptimized" content="320" />';
echo '</head>';
echo '<body>';
echo '	<div id="floater"></div>';
echo '	<div id="loginWindowWrap" class="clearfix">';
echo '		<div id="loginWindow">';
echo '			<h1>Login</h1>';
echo '			<form id="loginForm" method="post" name="loginForm" action="">';
echo '				<fieldset>';
echo '					<label for="username">Username </label>';
echo '					<input type="text" name="username" id="username" class="bigform" value=""/>';
echo '				</fieldset>';
echo '				<fieldset>';
echo '					<label id="password" >Password </label>';
echo '					<input type="password" name="pwd" class="bigform" id="password"value="" />';
echo '				</fieldset>';
if (is_string($result))
{
	echo $result; // outputs error message, if login was unsuccessful exits
}
echo '				<fieldset>';
echo '				<input name="login" type="submit" class="login" value="login" />';
echo '				</fieldset>';
echo '			</form>';
echo '			<p><a href="registration.php" data-ajax="false">Don\'t have an account yet? Register!</a></p><br />';
//echo '			<p><a href="resetpass.php">Click Here to reset your password.</a></p>';
echo '		</div>';
echo '	</div>';
echo '	<footer>';
echo '	</footer>';
echo '</body>';
echo '</html>';
?>