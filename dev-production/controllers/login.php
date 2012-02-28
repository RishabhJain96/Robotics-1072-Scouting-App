<?php
/**
 * Login class
 * @author Rohit Sanbhadti
 */

class login extends roboSISAPI
{
	// instance variables
	protected $_dbConnection;
	
	public function __construct()
	{
		$this->_dbConnection = dbUtils::getConnection();
		$this->_connection = $this->_dbConnection->open_db_connection();
	}
	
	public function checkLogin($username, $password)
	{
		// checks if username exists
		$resourceid = $this->_dbConnection->selectFromTable("RoboUsers", "Username", $username);
		$arr = $this->_dbConnection->formatQueryResults($resourceid, "Username");
		if (empty($arr) || is_null($arr[0]))
		{
			// username does not exist
			return "<p>The username $username does not exist.</p>";
		}
		
		// checks if given username has given password
		$md5password = md5($password); // required, since passwords in db are md5 hashed
		$resourceid2 = $this->_dbConnection->selectFromTable("RoboUsers", "Username", $username);
		$arr2 = $this->_dbConnection->formatQueryResults($resourceid2, "UserPassword");
		if (strcmp($md5password,$arr2[0]) == 0)
		{
			// username and password are valid
			return true;
		}
		else
		{
			// password is incorrect
			return "<p>Your password is incorrect.</p>";
		}
	}
	
}

?>