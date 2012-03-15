<?php
include "autoloader.php";
?>
<!doctype html>
<head>
	<meta charset="utf-8">
	<title>Robotics 1072 Registration</title>
	<meta name="description" content="">
	<meta name="author" content="">
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
	
</head>
<body>
	<div id="floater"></div>
	<div id="loginWindowWrap" class="clearfix">
		<div id="loginWindow">
			<h1>Register</h1>
			<form id="loginForm" method="post" name="loginForm" action="">
				<fieldset>
					<label for="username">Harker Username </label>
					<input type="text" name="username" id="username" class="bigform" value=""/>
				</fieldset>
				<fieldset>
					<label id="password" >Password </label>
					<input type="password" name="pwd" id="password" class="bigform" value="" />
				</fieldset>
				<fieldset>
					<label for="phonenum">Cell-Phone (###) ###-####</label>
					<input type="text" name="phonenum" id="username" class="bigform" value=""/>
				</fieldset>
				<fieldset>
				<input name="register" type="submit" class="register" value="register" />
				</fieldset>
				<?php
				if (isset($_POST['register']))
				{
					$username = $_POST['username'];
					$password = $_POST['pwd'];
					$phonenumber = $_POST['phonenum'];
					
					if($username =="")
					{
						exit("Please complete all fields and try again.");
					}
					if($phonenumber == "")
					{
						exit("Please complete all fields and try again.");
					}
					$username = strtolower($username);
					$register = new register();
					if ($register->register($username, $password, $phonenumber))
					{
						echo '<p>Congratulations! Your account has been set up and you may now <a href="loginpage.php" data-ajax="false">login</a>.</p>';
					}
				}
				?>
			</form>
		</div>
	</div>
	<footer>
	</footer>
</body>
</html>