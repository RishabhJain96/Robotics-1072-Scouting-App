<?php
/**
 * Robotics Student Information System General API
 * This api currently supports inputing a checkin, getting an array of all checkins, and getting a userID for a given username
 */

class generalController
{
	// constants
	
	// instance variables
	protected $_dbConnection;
	
	public function __construct()
	{
		$this->_dbConnection = dbUtils::getConnection();
		$this->_connection = $this->_dbConnection->open_db_connection();
		date_default_timezone_set('America/Los_Angeles'); // all times are in PST
	}
	
	
	// GENERAL FUNCTIONS
	
	
	/**
	 * description: Sanitizes the input data by escaping for MySQL entry, stripping HTML tags, and trimming whitespace.
	 * 
	 * @param input: The string to be sanitized for entry.
	 * @return string: Returns the sanitized $input data.
	 */
	public function sanitize($input)
	{
		$input = trim($input);
		$input = strip_tags($input);
		$input = mysql_real_escape_string($input);
		//$input = rtrim($input); // superfluous after trim
//		if (strpos($input,">"))
//			$input = preg_replace(">","",$input);
//		if (!get_magic_quotes_gpc()) { 
//			$input=addslashes($input); 
//		}
		return $input;
	}
	
	/**
	 * description: Uses the previously defined sanitize function to iteratively sanitize everything in an array.
	 * 
	 * @param array: The array with the values to sanitize.
	 * @return array: The sanitized array.
	 */
	public function sanitizeArray($array)
	{
		foreach ($array as &$value) {
			$value = $this->sanitize($value);
		}
		return $array;
	}	
}
?>
