<?PHP
// autoloader code
// loads classes as needed, eliminates the need for a long list of includes at the top
spl_autoload_register(function ($className) { 
    $possibilities = array( 
        '../controllers'.DIRECTORY_SEPARATOR.$className.'.php', 
        '../back_end'.DIRECTORY_SEPARATOR.$className.'.php', 
        '../views'.DIRECTORY_SEPARATOR.$className.'.php', 
        $className.'.php' 
    ); 
    foreach ($possibilities as $file) { 
        if (file_exists($file)) { 
            require_once($file); 
            return true; 
        } 
    } 
    return false; 
});

$relation = new relationalDbConnections('lala', 'localhost:3306', 'root', 'root');

$array = array("CollegeUrl" => "http://google.com", "CollegePresident" => "Abhinav Khanna");

/**
 * Example usage of InsertIntoTable. Property1: is the Table You are updating, Property2, the place you are checking for your PrimaryID
 * 			Property3 is the Column You are checking exists, Property4 is the CollegeName, Property5 is the primaryKey,
 * 			$array is the array of IDs for the insertion.
 */
//$relation->insertIntoTable("CollegeSummary","CollegeSummary", "CollegeName", "Harvard_University", "CollegeID", $array);
$relation->updateTable("CollegeSummary","CollegeSummary", "CollegeName", "Princeton_University", "CollegeID", $array, "CollegeName = 'Princeton_University'");

$relation->close_db_connection();
?>