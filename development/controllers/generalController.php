<?php
/**
 * Robotics Scouting App General Controller
 * This controller handles pulling and pushing all data from the database.
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
	
	/**
	 * description: Returns the UserID of the given username.
	 * 
	 * @param username: The username to get the userID of.
	 * @return int: Returns the userID on success, false otherwise.
	 */
	public function getUserID($username)
	{
		$resourceid = $this->_dbConnection->selectFromTable("Users", "Username", $username);
		$array = $this->_dbConnection->formatQueryResults($resourceid, "UserID");
		if (empty($array) || is_null($array[0])) // NOTE: can't destinguish between null value in table and invalid attribute parameter (both return array with single, null element)
		{
			error_log("username $username does not exist");
			//echo "<p>The username $username does not exist!</p>";
			return false;
		}
		
		return $array[0];
	}
	
	// GETTER FUNCTIONS
	
	/**
	 * description: Return the teamID of the given team.
	 * 
	 * @param teamName: 
	 * @return int: 
	 */
	public function getTeamID($teamName)
	{
		$resourceid = $this->_dbConnection->selectFromTable("Teams", "TeamName", $teamName);
		$array = $this->_dbConnection->formatQueryResults($resourceid, "TeamID");
		return $array[0];
	}
	
	/**
	 * description: 
	 * 
	 * @param teamID: 
	 * @return string: 
	 */
	public function getTeamName($teamID)
	{
		$resourceid = $this->_dbConnection->selectFromTable("Teams", "TeamID", $teamID);
		$array = $this->_dbConnection->formatQueryResults($resourceid, "TeamName");
		return $array[0];
	}
	
	/**
	 * description: 
	 * 
	 * @param teamID: 
	 * @return int: 
	 */
	public function getTeamNumber($teamID)
	{
		$resourceid = $this->_dbConnection->selectFromTable("Teams", "TeamID", $teamID);
		$array = $this->_dbConnection->formatQueryResults($resourceid, "TeamNumber");
		return $array[0];
	}
	
	/**
	 * description: This method should return an array of all the team names in the database.
	 *  
	 * @return array: A one-dimensional array with each element being a string of the team name.
	 */
	public function getAllTeamNames()
	{
		$resourceid = $this->_dbConnection->selectFromTable("Teams");
		$array = $this->_dbConnection->formatQueryResults($resourceid, "TeamName");
		return $array;
	}
	
	/**
	 * description: This method returns a list of all the information stored in the CategoryList table about a particular team.
	 * 
	 * @param teamID: The team to get the information of.
	 * @return array: A one-dimensional array of the info for the given team in the format array("CategoryName" => "CategoryContent"), with CategoryName for each category being the keys and CategoryContent being the values.
	 */
	public function getTeamInfoList($teamID)
	{
		$resourceid = $this->_dbConnection->selectFromTable("TeamInfo", "TeamID", $teamID);
		$arrayName = $this->_dbConnection->formatQueryResults($resourceid, "CategoryName");
		$resourceid2 = $this->_dbConnection->selectFromTable("TeamInfo", "TeamID", $teamID);
		$arrayContent = $this->_dbConnection->formatQueryResults($resourceid2, "CategoryContent");
		$resourceid3 = $this->_dbConnection->selectFromTable("TeamInfo", "TeamID", $teamID);
		$arrayinfoids = $this->_dbConnection->formatQueryResults($resourceid3, "TeamInfoID");
		$arr = array($arrayName, $arrayContent, $arrayinfoids);
		return $arr;
	}
	
	/**
	 * description: This method returns an array of all the team numbers in the database.
	 *  
	 * @return array: A one-dimensional array with each element being a string of the team number.
	 */
	public function getAllTeamNumbers()
	{
		$resourceid = $this->_dbConnection->selectFromTable("Teams");
		$array = $this->_dbConnection->formatQueryResults($resourceid, "TeamNumber");
		return $array;
	}
	
	/**
	 * description: This method returns an array of all the team ids in the database.
	 * 
	 * @return array: A one-dimensional array with each element being an int of the teamID.
	 */
	public function getAllTeamIds()
	{
		$resourceid = $this->_dbConnection->selectFromTable("Teams");
		$array = $this->_dbConnection->formatQueryResults($resourceid, "TeamID");
		return $array;
	}
	
	/**
	 * description: This method writes a new team to the database with the given TeamName and TeamNumber.
	 * 
	 * @param teamName: The team name as a string
	 * @param teamNumber: The team number as a string
	 * @param username: The username of the submitting user.
	 * @return int: Returns the teamID of the newly generated team on success (the teamID is autogenerated in MySQL), or false on failure.
	 */
	public function inputNewTeam($teamName, $teamNumber, $username = null)
	{
		// logs the date and time that the user submitted the info in both a human-readable and easy-to-manipulate format
		$englishTimestamp = date("l, F j \a\\t g:i a"); // Friday, September 23 at 11:05 pm;
		$numericTimestamp = date("YmdHi"); // 201109232355;
		$aTeam = array(
			"Username" => $username,
			"TeamName" => $teamName,
			"NumericDateUpdated" => $numericTimestamp,
			"EnglishDateUpdated" => $englishTimestamp,
			"TeamNumber" => $teamNumber
		);
		$aTeam = $this->sanitizeArray($aTeam);
		$result = $this->_dbConnection->insertIntoTable("Teams", "Teams", "TeamName", $teamName, "TeamName", $aTeam);
		if ($result) 
		{
			$teamID = $this->getTeamID($teamName);
			return $teamID;
		}
		return false; // failure to insert into db
	}
	
	/**
	 * description: Inputs the info for the given team into the TeamInfo table.
	 * 
	 * @param teamID: The team to enter the info for.
	 * @param infoArr: The information for the given team to be entered into the TeamInfo table with keys being CategoryNames and values being CategoryContent.
	 * @return boolean: true on success, false on failure.
	 */
	public function inputNewTeamInfo($teamID, $infoArr)
	{
		for ($i=0; $i < count($infoArr); $i++)
		{
			$arr = $infoArr[$i];
			$arr = $this->sanitizeArray($arr);
			$this->_dbConnection->insertIntoTable("TeamInfo", "Teams", "TeamID", $teamID, "TeamID", $arr);
		}
		return true;
	}
	
	/**
	 * description: Updated the given team name
	 * 
	 * @param teamID: 
	 * @return boolean: 
	 */
	public function updateTeam($teamID, $teamName, $teamNumber, $username = null)
	{
		// logs the date and time that the user submitted the info in both a human-readable and easy-to-manipulate format
		$englishTimestamp = date("l, F j \a\\t g:i a"); // Friday, September 23 at 11:05 pm;
		$numericTimestamp = date("YmdHi"); // 201109232355;
		$aTeam = array(
			"Username" => $username,
			"TeamName" => $teamName,
			"NumericDateUpdated" => $numericTimestamp,
			"EnglishDateUpdated" => $englishTimestamp,
			"TeamNumber" => $teamNumber
		);
		$aTeam = $this->sanitizeArray($aTeam);
		$result = $this->_dbConnection->updateTable("Teams", "Teams", "TeamID", $teamID, "TeamID", $aTeam, "TeamID = $teamID");
		return $result;
	}
	
	/**
	 * description: Updated the info for the given team into the TeamInfo table.
	 * 
	 * @param teamID: The team to update the info for.
	 * @param infoArr: The information for the given team to be updated the TeamInfo table with keys being CategoryNames and values being CategoryContent.
	 * @return boolean: true on success, false on failure.
	 */
	public function updateTeamInfo($teamID, $infoArr)
	{
		for ($i=0; $i < count($infoArr); $i++)
		{
			$arr = $infoArr[$i];
			$arr = $this->sanitizeArray($arr);
			$teamInfoID = $arr["TeamInfoID"];
			if (is_null($teamInfoID) || empty($teamInfoID))
			{
				//$this->_dbConnection->insertIntoTable("TeamInfo", "Teams", "TeamID", $teamID, "TeamID", $arr);
			}
			else
			{
				$this->_dbConnection->updateTable("TeamInfo", "TeamInfo", "TeamInfoID", $teamInfoID, "TeamID", $arr, "TeamInfoID = '$teamInfoID'");
			}
		}
		// update time updated
		//$englishTimestamp = date("l, F j \a\\t g:i a"); // Friday, September 23 at 11:05 pm;
		//$numericTimestamp = date("YmdHi"); // 201109232355;
		//$team = array(
		//	"NumericDateUpdated" => $numericTimestamp,
		//	"EnglishDateUpdated" => $englishTimestamp
		//);
		//$team = $this->sanitizeArray($team);
		//$this->_dbConnection->updateTable("Teams", "Teams", "TeamID", $teamID, "TeamID", $team, "TeamID = $teamID");
		return true;
	}
	
}
?>