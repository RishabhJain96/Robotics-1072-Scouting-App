<?PHP
class dbConnections
{
	//internal properties go below
	protected $_dbuser;
	protected $_dbpass;
	protected $_dbname;
	protected $_dbhost;
	protected $_conn;
	protected $_queryResults;
	protected $_connDB;
	
	//constructor goes below
	public function __construct($dbname, $dbhost, $dbuser, $dbpass = null) {
		try {
			$this->_dbuser = $dbuser;
			$this->_dbname = $dbname;
			$this->_dbhost = $dbhost;
			if(!is_null($dbpass)) {
				$this->_dbpass = $dbpass;
			}
		} catch(Exception $err) {
			throw new Exception('Could not construct the object');
			echo $err;
		}
	}
	
	//General Methods Below for the dbConnections class
	
	
	public function open_db_connection()
	{
		try{
			$this->_conn = mysql_connect($this->_dbhost, $this->_dbuser, $this->_dbpass);
			$this->_connDB = mysql_select_db($this->_dbname);
			return $this->_connDB;
		}
		catch(Exception $err) {
			throw new Exception("The script failed to connect to the database $this->_dbname at $this->_dbhost");
		}
	}
	
	/**
	 * Not working as of 24th June, 2011
	 */
	public function close_db_connection()
	{
		mysql_close($this->_conn);
	}
	
	//returns the result of the SELECT query;
	public function selectFromTable($tableName, $key = null, $value = null)
	{
		try{
			if(!is_null($key)) {
				if(!is_null($value)) {
					$result = mysql_query("SELECT * FROM `$tableName` WHERE `$key`='$value'");
					return $result;
				}
			} else {
				$result = mysql_query("SELECT * FROM $tableName");
				return $result;
			}
		}
		catch(Exception $err) {
			throw new Exception('Error: Could not connect execute the SELECT * FROM query as specified in selectFromTable() function!');
		}
	}
	
	// returns the mysql array in descending order of the column $orderColumn
	// author: wilbur yang
	public function selectFromTableDesc($tableName, $key = null, $value = null, $orderColumn)
	{
		try
		{
			if(!is_null($key))
			{
				if(!is_null($value))
				{
					$result = mysql_query("SELECT * FROM `$tableName` WHERE `$key`='$value' ORDER BY `$orderColumn` DESC");
					return $result;
				}
			}
			else
			{
				$result = mysql_query("SELECT * FROM `$tableName` ORDER BY `$orderColumn` DESC");
				return $result;
			}
		}
		catch(Exception $err)
		{
			throw new Exception('Error: Could not connect execute the SELECT * FROM query as specified in selectFromTable() function!');
		}
	}
	
	// returns the mysql array in ascending order of the colum $orderColumn
	// author: wilbur yang
	public function selectFromTableAsc($tableName, $key = null, $value = null, $orderColumn)
	{
		try
		{
			if(!is_null($key))
			{
				if(!is_null($value))
				{
					$result = mysql_query("SELECT * FROM `$tableName` WHERE `$key`='$value' ORDER BY `$orderColumn` ASC");
					return $result;
				}
			}
			else
			{
				$result = mysql_query("SELECT * FROM `$tableName` ORDER BY `$orderColumn` ASC");
				return $result;
			}
		}
		catch(Exception $err)
		{
			throw new Exception('Error: Could not connect execute the SELECT * FROM query as specified in selectFromTable() function!');
		}
	}
	
	//returns the result of the Insert query
	// array_fieldValues is the array of array('fieldId' => 'fieldValue');
	public function insertIntoTable($tableName, $array_fieldValues)
	{
		//change below testing code
		//	$result1 = mysql_query("INSERT INTO test (test) VALUES ('ll')");
		//	return $result1;
		
		//end of testing block
		$array_values = '';
		$array = '';
		$count = 1;
		if(is_array($array_fieldValues)) {
			//iterate through the array for all the values
			foreach($array_fieldValues as $key => $value) {
				if($count < count($array_fieldValues)) {
					$array_values = "$array_values '$value',";
					$array = "$array `$key`,";
					$count = $count + 1;
				} else {
					$array_values = trim("$array_values '$value'");
					$array = trim("$array `$key`");
				}
			}
			//return $array_values;
			//print_r($array);
			try {
				//testing code below
				//return "INSERT INTO $tableName ($array) VALUES ($array_values)";
				//testing block end
				$result = mysql_query("INSERT INTO $tableName ($array) VALUES ($array_values)");
				//change made
				//print_r("INSERT INTO $tableName ($array) VALUES ($array_values)");
				return $result;
			} catch(Exception $err) {
				throw new Exception("Error occurred while inserting $array_values into $array in $tableName");
			}
		} else {
			throw new Exception('function insertIntoTable must receive arrays for the last parameter');
		}
	}
	
	//returns the result of the UPDATE Mysql query
	// param: $fieldIds has to be an array
	// the fieldIds array should have its corresponding fieldValue mapped to the fieldId it corresponds to;
		// e.g. array("field1" => "value1", "field2" => "value2")
	//condition should be in the form of 'FieldName = some FieldValue'
	public function updateTable($tableName, $fieldIds, $condition)
	{
		$array_values = '';
		$count = 1;
		if(is_array($fieldIds)) {
			//iterate through the array for all the values
			foreach($fieldIds as $key => $value) {
				if($count < count($fieldIds)) {
					$array_values = "$array_values $key='$value',";
					$count = $count + 1;
				} else {
					$array_values = "$array_values $key='$value'";
				}
			}
			try{
				$result = mysql_query("UPDATE $tableName SET $array_values WHERE $condition");
				//if($result) print '4';
				//print "UPDATE $tableName SET $array_values WHERE $condition";
				//Test code below
				//$result = "UPDATE $tableName SET $array_values WHERE $condition";
				return $result;
			} catch(Exception $err) {
				throw new Exception("Error occurred while updating $array_values into $tableName");
			}
		} else {
			throw new Exception('the updateTable only takes arrays for the middle parameters');
		}
	}
	
	/**
	 * Used to format the queryResults into a readable Array rather than a resource ID.
	 * @param: $value is the resource
	 * @param: $field (optional) is the field (or column) from the data set you would like to extract.
	 */
	public function formatQueryResults($value, $field = null)
	{
		$array = array();
		$i = 0;
		if(!is_null($field)) {
			while($rows = mysql_fetch_array($value)) {
				$array[$i] = $rows[$field];
				$i++;
			}
			return $array;
		} else {
			$rows = mysql_fetch_array($value);
			return $rows;
		}
	}
	
	/**
	 * Public method selectFromTableMultiple
	 * Will select from the Database table the entries that fit the various filters ($key1, $key2 and their respective values)
	 * Only the entries that satisfy both requirements will be passed through;
	 */
	public function selectFromTableMultiple($tableName, $key1, $value1, $key2, $value2)
	{
		$result = mysql_query("SELECT * FROM $tableName WHERE $key1='$value1' AND $key2='$value2'");
		return $result;
	}
	
	/**
	 * description: Check if the given table is empty.
	 * 
	 * @param table: The table to check emptiness of.
	 * @return bool: true if empty, false otherwise
	 */
	public function tableIsEmpty($table)
	{
		//print 'checking table empty';
		$sql = "SELECT * FROM $table";
		$result = @mysql_query($sql);
		print_r($result);
		if (!$result)
		{
			//print 'table empty';
			return true;
		}
		else
		{
			//print 'table not empty';
			return false;
		}
	}
}