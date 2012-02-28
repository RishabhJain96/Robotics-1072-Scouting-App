<?php
/**
 * This script was heavily based on the open-source PHP project Jorp. The project and all it's original source code can be found at http://jorp.sourceforge.net/.
 * @author Rohit Sanbhadti
 * date: Feb 15 2012
 */
include "autoloader.php";
//include('header.php');
if (isset($_POST['submit']))
{
	// tests the connection
	$conn = mysql_connect("".$_POST['db_host']."", "".$_POST['db_username']."", "".$_POST['db_password']."") or die("The credentials you supplied are invalid. Please try again.");
	
	$db_host = "".$_POST['db_host']."";
	//$db_name = "".$_POST['db_name']."";
	$db_name = "RoboticsScoutingApp"; // hardcoded because the user shouldn't have to worry about the database name
	$db_username = "".$_POST['db_username']."";
	$db_password = "".$_POST['db_password']."";
	//$mentor_name = "".$_POST['mentor_name']."";
	//$mentor_pass = "".$_POST['mentor_pass'].""; // will be md5'd upon register
	$team_name = "".$_POST['team_name']."";
	$school_name = "".$_POST['school_name']."";
	
	$data = "$db_name\n$db_host\n$db_username\n$db_password";
	
	// copies text file with connection info to all subfolders
	$db_config = "../back_end/dbParameters.txt";
	$db_handle = fopen($db_config, "w") or die("can't open file");
	fwrite($db_handle, $data);
	fclose($db_handle);
	
	$db_config = "../controllers/dbParameters.txt";
	$db_handle = fopen($db_config, "w") or die("can't open file");
	fwrite($db_handle, $data);
	fclose($db_handle);
	
	$db_config = "../views/dbParameters.txt";
	$db_handle = fopen($db_config, "w") or die("can't open file");
	fwrite($db_handle, $data);
	fclose($db_handle);
	
	$db_config = "../setup/dbParameters.txt";
	$db_handle = fopen($db_config, "w") or die("can't open file");
	fwrite($db_handle, $data);
	fclose($db_handle);
	
	// writes constants
	$constantsData = "<?php\n\$schoolName = \"$school_name\";\n\$teamName = \"$team_name\";\n?>";
	$constants = "../views/constants.php";
	$db_handle = fopen($constants, "w") or die("can't open file");
	fwrite($db_handle, $constantsData);
	fclose($db_handle);
	
	// sets up the table and database
	
	$dbConfig = dbUtils::getPropertiesConnection();
	
	$register = new register();
	$phonenumber = "N/A";
	
	$dbConfig->createDatabase($db_name);
	
	// setting up tables
	include "dbConfig.php";
	
	// registering mentor
	//$register->register($mentor_name, $mentor_pass, $phonenumber, "Mentor");
	
	echo "<div id=\"contentContainer\">

		<div class=\"header\">
			<!-- Install Purchase Order System -->
		</div>

		<div class=\"content\">";

		echo "The PO system has been installed successfully. You may now log in <a href=\"../index.php\">here</a>.";

	echo   "</div> <!--end content-->";

	echo "</div>";
	}

else {
	echo "<div id=\"contentContainer\">

		<div class=\"header\">
			<!-- Install Purchase Order System -->
		</div>

		<div class=\"content\">";

        echo 		"<center>";
        echo 		"<table border=\"0\" width=\"400\"><tr><td>";

        echo 		"<form enctype=\"multipart/form-data\" action=\"\" method=\"post\">\n";

	echo 		"<label for=\"db_host\">MySQL Hostname: </label><input type=\"text\" value=\"localhost\" maxlength=\"150\" name=\"db_host\"/><br />\n";

        //echo 		"<label for=\"db_name\">MySQL Database Name: </label><input type=\"text\" value=\"\" maxlength=\"150\" name=\"db_name\"><br />\n";

        echo 		"<label for=\"db_username\">MySQL Database Username: </label><input type=\"text\" value=\"root\" maxlength=\"150\" name=\"db_username\"><br />\n";
		
        echo 		"<label for=\"db_password\">MySQL Database Password: </label><input type=\"password\" value=\"\" maxlength=\"150\" name=\"db_password\"/><br /><br />\n";
		
		echo 		"<label for=\"team_name\">Team Name: </label><input type=\"text\" value=\"\" maxlength=\"150\" name=\"team_name\"><br />\n";
		
		echo 		"<label for=\"school_name\">School Name: </label><input type=\"text\" value=\"\" maxlength=\"150\" name=\"school_name\"><br />\n";
		
		echo 		"<label for=\"mentor_name\">Mentor Username: </label><input type=\"text\" value=\"\" maxlength=\"150\" name=\"mentor_name\"><br />\n";
		
		echo 		"<label for=\"mentor_pass\">Mentor Password: </label><input type=\"password\" value=\"\" maxlength=\"150\" name=\"mentor_pass\"><br />\n";

 	echo 		"<input type=\"submit\" name=\"submit\" value=\"Install PO System\" class=\"send\"/>";
 
	echo 		"</form>";

	echo 		"</td></tr></table>";
	echo 		"</center>";

	echo   "</div> <!--end content-->";

	echo "</div>";

}

//include('footer.php');

?>
