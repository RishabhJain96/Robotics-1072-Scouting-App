<?php
/**
 * Robotics Register class
 * @author: Rohit Sanbhadti
 * Inputs the username and password in the database, along with a randomly generated activation number. Automatically inputs the user as 
 * This class also handles changing a user's password.
 */

class register extends roboSISAPI
{
	// constants
	const DEFAULT_PASS = "qwerty";
	
	// instance variables
	protected $_dbConnection;
	protected $_nonRelationalDbConnection;
	
	public function __construct()
	{
		$this->_dbConnection = dbUtils::getConnection();
		$this->_connection = $this->_dbConnection->open_db_connection();
		//$this->_nonRelationalDbConnection= dbUtils::getNonRelationalConnection();
	}
	
	/**
	 * combines all other methods under one hood. returns true on success and if the username is taken message on failure.
	 */
	public function register($username, $password, $phonenumber, $type = null)
	{
		$code = md5(mt_rand());
		$username = parent::sanitize($username);
		$password = parent::sanitize($password);
		$phonenumber = parent::sanitize($phonenumber);
		$result = $this->inputNewUser($username, $password, $phonenumber, $code, $type); // inputs a new user if username is not taken
		if ($result) // activates only if input is succesful
		{
			//$this->inputEmail($username); // this method becomes useful if everyone uses a school email, because then the method can just concatenate the school's domain to the end of the username. 
			$this->activateNewUser($username, $code);
			return true; // success in inputting user
		}
		else
		{
			return false; // username already taken
		}
	}
	
	/**
	 * This function checks if the given username already exists in the database. It returns a string protesting the existence of the given username if it finds it in the db, otherwise it creates the username/password combo in the db
	 * Inputs a new user into the database with type given by $type, default type is regular
	 */
 	public function inputNewUser($username, $password, $phonenumber, $code, $type = null)
 	{
 		// checks if username already exists in db
 		$resourceid = $this->_dbConnection->selectFromTable("RoboUsers", "Username", $username);
 		$arr = $this->_dbConnection->formatQueryResults($resourceid, "Username");
 		if (count($arr) > 0)
 		{
 			error_log("This username is already taken!");
 			//print 'The username ' . $username . ' is already taken! Please choose a different one.'; // for debugging purposes
 			echo "<p>The username $username is already taken! Please choose a different one.</p>";
 			return false;
 		}
 		// username is a valid, new username at this point
 		$password = md5($password); // encodes password in md5 for security/privacy
 		//print_r($passwordCoded);
		if (is_null($type))
		{
			$type = "Regular"; // user is regular unless changed specifically
		}
 		$array = array("ActivationCode" => $code, "Username" => $username, "UserPassword" => $password, "UserPhoneNumber" => $phonenumber, "UserType" => $type);
 		$this->_dbConnection->insertIntoTable("RoboUsers", "RoboUsers", "Username", $username, "UserID", $array);
 		return true;
 	}
	
	/**
	 * This is a separate function because it's existence is not necessarily required, but it seems smart to have it.
	 * This function inputs the user's harker email based on their username.
	 * Assumes that username is harker username.
	 */
	public function inputEmail($username)
	{
		$email = "" . $username . "@students.harker.org"; // assumes user is using their student email
		$array = $array = array("UserEmail" => $email);
		//print 'updating table in input email';
		//$this->_nonRelationalDbConnection->updateTable("RoboUsers", $array, "Username = '$username'");
		$this->_dbConnection->updateTable("RoboUsers", "RoboUsers", "Username", $username, "UserID", $array, "Username = '$username'");
	}
	
	/**
	 * emails the user with activation link to activate account
	 */
	public function activateNewUser($username, $code)
	{
		// in-place activation code
		$bool = 1; // any nonzero value to indicated activated status
		$stuffing = "Activated"; // clears the activation code field of its md5 to prevent accidental re-activation
		$array = array("Activated" => $bool, "ActivationCode" => $stuffing);
		//$this->_nonRelationalDbConnection->updateTable("RoboUsers", $array, "ActivationCode = '$code'");
		$this->_dbConnection->updateTable("RoboUsers", "RoboUsers", "ActivationCode", $code, "UserID", $array, "ActivationCode = '$code'");

		//echo 'Congratulations! Your account has been activated.';
	}
	
	/**
	 * description: Returns the given user's current password.
	 * 
	 * @param username: The user who's password to get
	 * @return string: The password, straight from the database (still in md5 form)
	 */
	public function getPassword($username)
	{
		$resourceid = $this->_dbConnection->selectFromTable("RoboUsers", "Username", $username);
		$array = $this->_dbConnection->formatQueryResults($resourceid, "UserPassword");
		return $array[0];
	}
	
	/**
	 * description: Reset the password to a hardcoded constant
	 * 
	 * @param username: 
	 * @return int: 
	 */
	public function resetPassword($username)
	{
		$password = self::DEFAULT_PASS;
		$this->setPassword($username, $password);
	}
	
	/**
	 * description: 
	 * 
	 * @param password: 
	 * @param username: 
	 * @return int: 
	 */
	public function setPassword($username, $password)
	{
		$password = md5($password);
		$condition = "Username = '$username'";
		$array = array("UserPassword" => $password);
		$this->_dbConnection->updateTable("RoboUsers", "RoboUsers", "Username", $username, "UserID", $array, $condition);
	}
}

?>