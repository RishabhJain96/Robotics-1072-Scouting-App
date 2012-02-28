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
//$users[] = array("UserDescription", "TEXT"); // needed?
$users[] = array("UserPhoneNumber", "TINYTEXT");
$users[] = array("UserYear", "INT");
//$users[] = array("UserMomEmail", "TINYTEXT"); // split into mom/dad email?
$users[] = array("UserParentsEmail", "TINYTEXT"); // split into mom/dad email?
$users[] = array("UserEmail", "TINYTEXT");
//$users[] = array("UserTitle", "TINYTEXT"); // needed?
//$users[] = array("UserPicture", "TINYTEXT"); // needed?
$users[] = array("UserPassword", "TINYTEXT");
$users[] = array("ActivationCode", "TINYTEXT");
$users[] = array("Activated", "INT"); // nonzero val is true
$users[] = array("UserSubteam", "TINYTEXT"); // vals: Mechanical, Electronics, Programming, Operational
$users[] = array("UserType", "TINYTEXT"); // vals: Regular, VP, Admin, Mentor

if($dbConfig->createINNODBTable("RoboUsers", $users))
	echo "Success! Your RoboUsers Table is now set up! <br />";

/**
 * Teams Table
 */
$teams = array();
$teams[] = array("TeamID", "int", "NOT NULL", "AUTO_INCREMENT");
$teams[] = array("PRIMARY KEY(TeamID)");
$teams[] = array("TeamName", "TINYTEXT");
$teams[] = array("TeamNumber", "TINYTEXT");
$teams[] = array("UserID", "INT");
	
if($dbConfig->createINNODBTable("Teams", $teams))
	echo "Success! Your Teams Table is now set up! <br />";
if($dbConfig->setRelation("UserHistories", "Users", "UserID"))
	echo "Success! Your Teams and Users Table are now linked via UserID! <br />";

/**
 * CategoryList Table
 */
$category = array();
$category[] = array("CategoryListID", "int", "NOT NULL", "AUTO_INCREMENT");
$category[] = array("PRIMARY KEY(CategoryListID)");
$category[] = array("TeamID", "INT");
$category[] = array("CategoryName", "TINYTEXT");
$category[] = array("CategoryContent", "TEXT");
	
if($dbConfig->createINNODBTable("CategoryList", $category))
	echo "Success! Your CategoryList Table is now set up! <br />";
if($dbConfig->setRelation("CategoryList", "Teams", "TeamID"))
	echo "Success! Your CategoryList and Teams Tables are now linked via TeamID! <br />";


?>