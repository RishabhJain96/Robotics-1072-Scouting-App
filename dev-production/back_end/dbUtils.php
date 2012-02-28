<?php
/**
 * A static utilities class to hold dbConnection-related functions.
 */
class dbUtils
{
	public static function getConnection()
	{
		$dbArr = array();
		$dbArr = file("dbParameters.txt", FILE_IGNORE_NEW_LINES);
		$dbConnection = new relationalDbConnections($dbArr[0], $dbArr[1], $dbArr[2], $dbArr[3]);
		return $dbConnection;
	}
	
	public static function getPropertiesConnection()
	{
		$dbArr = array();
		$dbArr = file("dbParameters.txt", FILE_IGNORE_NEW_LINES);
		$dbConnection = new databaseProperties($dbArr[0], $dbArr[1], $dbArr[2], $dbArr[3]);
		return $dbConnection;
	}
	
	public static function getNonRelationalConnection()
	{
		$dbArr = array();
		$dbArr = file("dbParameters.txt", FILE_IGNORE_NEW_LINES);
		$dbConnection = new dbConnections($dbArr[0], $dbArr[1], $dbArr[2], $dbArr[3]);
		return $dbConnection;
	}
}

?>