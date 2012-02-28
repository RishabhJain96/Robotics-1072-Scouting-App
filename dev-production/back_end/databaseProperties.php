<?PHP
/**
 * databaseProperties class
 * Configures the database correctly
 * @package default
 * @author Abhinav  Khanna
 **/
class databaseProperties extends dbConnections
{
	
	public function __construct($dbname, $dbhost, $dbuser, $dbpass = null)
	{
		parent::__construct($dbname, $dbhost, $dbuser, $dbpass);
		$this->open_db_connection();
	}
	
	/**
	 * public function createTable
	 * @param: $tableName = the table you wish to create
	 * @param: $column is a reference to an array of the columns you are going to have in your table.
	 * 			The set up for the array is in an array(0 => array(ColumnName, setting1, setting2, . . . ), 1 => array(....))
	 */
	public function createINNODBTable($tableName, $columns)
	{
		$query = "CREATE TABLE $tableName(";

		for($i = 0; $i < count($columns); $i++)
		{
			for($j = 0; $j < count($columns[$i]); $j++)
			{
				if($j == 0) $query = $query . "". $columns[$i][$j] . " ";
				else $query = $query . "". $columns[$i][$j]." ";
			}
			
			if($i + 1 != count($columns))
				$query = $query . ", ";
			else
				$query = $query . ") ENGINE = INNODB";
		}
		
	//	return $query;
	//	$result = mysql_query($query, $this->_conn);
	//	return $result . " \n" . mysql_error($result);
		
		if(mysql_query($query)) return true;
		else return false;
	}
	
	public function createDatabase($dbName)
	{
		$query = "CREATE DATABASE `$dbName`";
		if(mysql_query($query)) return true;
		else return false;
	}
	
	/**
	 * public function setRelation($table1, $table2, $foreignKey);
	 * @param: table1 is the table you wish to link
	 * @param: table2 is the table you are linking to
	 * @param: $foreignkey is the foreignkey you are linking.
	 */
	public function setRelation($table1, $table2, $foreignKey)
	{
		$query = mysql_query("ALTER TABLE  `$table1` ADD FOREIGN KEY (  `$foreignKey` ) REFERENCES  `$this->_dbname`.`$table2` (
		`$foreignKey`)");
		
		if($query) return true;
		else return false;
	}
	
	/**
	 * Drops a Mysql Table, useful if you are going to add headers to the table, should never be used with a filled table.
	 */
	public function dropTable($tableName)
	{
		$query = "DROP TABLE `$tableName`";
		if(mysql_query($query)) return true;
		else return false;
	}
	
	/**
	 * Altercolumn
	 * Alter's a given column.
	 */
	public function alterColumn($tableName, $oldColumnName, $newColumnName, $properties)
	{
		$query = "ALTER TABLE `$tableName` CHANGE `$oldColumnName` `$newColumnName` $properties";
		
		if(mysql_query($query)) return true;
		else return false;
	}
	
	
} // END class 