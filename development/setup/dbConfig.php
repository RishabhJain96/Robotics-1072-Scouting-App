<?php
include "autoloader.php";

/**
 * PLEASE MAKE SURE THAT THE DATABASE WITH THE APPROPRIATE dbName FROM dbParameters.txt
 * HAS ALREADY BEEN MADE MANUALLY IN THE MYSQL BACK-END, ELSE THIS CODE WILL NOT WORK.
 * 
 */
$dbConfig = dbUtils::getPropertiesConnection();

/**
 * Users Table
 */
$users = array();
$users[] = array("UserID", "int", "NOT NULL", "AUTO_INCREMENT");
$users[] = array("PRIMARY KEY(UserID)", "");
$users[] = array("Username", "TEXT");
$users[] = array("UserFullName", "TINYTEXT");
$users[] = array("UserPhoneNumber", "TINYTEXT");
$users[] = array("UserYear", "INT");
$users[] = array("UserParentsEmail", "TINYTEXT"); // split into mom/dad email?
$users[] = array("UserEmail", "TINYTEXT");
$users[] = array("UserPassword", "TINYTEXT");
$users[] = array("ActivationCode", "TINYTEXT");
$users[] = array("Activated", "INT"); // nonzero val is true
$users[] = array("UserSubteam", "TINYTEXT"); // vals: Mechanical, Electronics, Programming, Operational
$users[] = array("UserType", "TINYTEXT"); // vals: Regular, VP, Admin, Mentor

if($dbConfig->createINNODBTable("Users", $users))
	echo "Success! Your Users Table is now set up! <br />";

/**
 * Teams Table
 */
$teams = array();
$teams[] = array("TeamID", "int", "NOT NULL", "AUTO_INCREMENT");
$teams[] = array("PRIMARY KEY(TeamID)");
$teams[] = array("TeamName", "TINYTEXT");
$teams[] = array("TeamNumber", "TINYTEXT");
//$teams[] = array("UserID", "INT"); // UserID of the user who most recently inputted/updated the team info.
$teams[] = array("Username", "TINYTEXT"); // Username of the user who most recently inputted/updated the team info. Username stored for faster access
$teams[] = array("NumericDateUpdated", "TINYTEXT"); // format YYYYMMDDHHmm '201109091706'
$teams[] = array("EnglishDateUpdated", "TINYTEXT"); // fromat 'September 9, 2011 at 5:06 pm'
	
if($dbConfig->createINNODBTable("Teams", $teams))
	echo "Success! Your Teams Table is now set up! <br />";
//if($dbConfig->setRelation("Teams", "Users", "UserID"))
//	echo "Success! Your Teams and Users Table are now linked via UserID! <br />";

/**
 * CategoryList Table
 */
$category = array();
$category[] = array("TeamInfoID", "int", "NOT NULL", "AUTO_INCREMENT");
$category[] = array("PRIMARY KEY(TeamInfoID)");
$category[] = array("TeamID", "INT");
$category[] = array("CategoryName", "TINYTEXT");
$category[] = array("CategoryContent", "TEXT");
	
if($dbConfig->createINNODBTable("TeamInfo", $category))
	echo "Success! Your TeamInfo Table is now set up! <br />";
if($dbConfig->setRelation("TeamInfo", "Teams", "TeamID"))
	echo "Success! Your TeamInfo and Teams Tables are now linked via TeamID! <br />";


?>