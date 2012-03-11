<?PHP
/**
 * relationalDbConnections class
 *
 * @package default
 * @author Abhinav  Khanna
 **/
class relationalDbConnections extends dbConnections
{
	
	public function __construct($dbname, $dbhost, $dbuser, $dbpass = null)
	{
		parent::__construct($dbname, $dbhost, $dbuser, $dbpass);
		$this->_conn = $this->open_db_connection();
	}
	
	public function selectWithJoin()
	{
		throw new Exception("Implement Me!");
	}
	
	public function insertIntoTable($tableName1, $keyTable, $foreignKey, $valueForKey, $primaryKey, $arrayOfValues)
	{
		$result = $this->selectFromTable($keyTable, $foreignKey, $valueForKey);
		$num = mysql_num_rows($result);
		if($num == 0 && ($tableName1 != $keyTable))
		{
			$array = array($foreignKey => "$valueForKey");
			parent::insertIntoTable($keyTable, $array);
			$result1 = parent::selectFromTable($keyTable, $foreignKey, $valueForKey);
			$formatted = $this->formatQueryResults($result1, $primaryKey);
			$arrayOfValues[$primaryKey] = $formatted[0];
			parent::insertIntoTable($tableName1, $arrayOfValues);
			return true;
		}
		elseif($num == 0 && ($tableName1 == $keyTable))
		{
			$arrayOfValues[$foreignKey] = $valueForKey;
			parent::insertIntoTable($tableName1, $arrayOfValues);
			return true;
		}
		elseif($tableName1 != $keyTable && $num != 0)
		{
			$formatted = $this->formatQueryResults($result, $primaryKey);
			$arrayOfValues[$primaryKey] = $formatted[0];
			return parent::insertIntoTable($tableName1, $arrayOfValues); // return true if insertIntoTable returns true, false otherwise
			// return true;
		}
		else
		{
			return false;
		}
		
	}
	
	/**
	 * will update the Relational DB table; if trying to update the table containing the key, give both $tableName1 and $keyTable as the
	 * 			same value.
	 * @param: $tableName1: the table you wish to update
	 * @param: $keyTable: the table containing the cross-table Key
	 * @param: $foreignkey: the foreignKey you're using to check;
	 * @param: $valueForKey: the value for the foreignKey;
	 * @param: $primaryKey: the primaryKey of the database (the cross-table Key);
	 * @param: $arrayOfValues: the values being updated;
	 * Postcondition: updates the table if entry already exists;
	 * Postcondition: creates a new entry if entry does not exist;
	 */
	public function updateTable($tableName1, $keyTable, $foreignKey, $valueForKey, $primaryKey, $arrayOfValues, $condition)
	{
		$result = $this->selectFromTable($keyTable, $foreignKey, $valueForKey);
		$num = mysql_num_rows($result);
		if($num == 0)
		{
			$this->insertIntoTable($tableName1, $keyTable, $foreignKey, $valueForKey, $primaryKey, $arrayOfValues);
			return true;
		}
		else
		{
			parent::updateTable($tableName1, $arrayOfValues, $condition);
			return true;
		}
	}
	
	/**
	 * duplicates formatQueryResults with tweaked functionality; returns associative array if field is null
	 */
	public function formatQuery($value, $field = null)
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
			$arr = array();
			//$rows = mysql_fetch_array($value, MYSQL_ASSOC);
			while($rows = mysql_fetch_array($value, MYSQL_ASSOC))
			{
				$arr[] = $rows;
			}
			if(empty($arr)) return $arr;
			if(count($arr)>0) return $arr;
			else return $arr[0];
		}
	}
	
	/**
	 * description: Deletes the given row from the given table.
	 * 
	 * @param tableName: The table to delete from.
	 * @param conditionKey: Name of column holding value
	 * @param conditionValue: Value in the column, specifies the row to delete
	 * @return boolean: 
	 */
	public function deleteFromTable($tableName, $conditionKey, $conditionValue)
	{
		$result = mysql_query("DELETE FROM $tableName WHERE $conditionKey='$conditionValue'");
		return $result;
	}
	
	/**
	 * 
	 */
//	public function writeToDatabse($tablename, $columntoupdate, $columnforid, $id)
//	{
//		this->updateTable($tablename, $columntoupdate, $columnforid, $id, $primarykeyforcolumntoupdate, ); // unfinished
//	}
	
	
} // END class 