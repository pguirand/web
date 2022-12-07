<?PHP include "class.xmlresponse.php"; 
$allowed_tables = array('individu'); 
$allowed_fields = array('NUM_NIF'); 
if(!isset($_POST['table']) || !($table = $_POST['table']) || !in_array($table, $allowed_tables)) die(); 
if(!isset($_POST['field']) || !($field = $_POST['field']) || !in_array($field, $allowed_fields)) die(); 
if(!isset($_POST['value'])) die(); 
$value = $_POST['value']; 
function isDuplicate($table, $field, $value) 
{ 
	if(!$value) return false; 
	// 
	// return value equating to true if a matching $value for $field exists in $table  
	// otherwise return false if no duplicate values exist 
	// 
} 
$xml = new xmlResponse(); 
$xml->start(); 
   # generate cammands to return in XML format  
   if(isDuplicate($table, $field, $value)) 
   { 
	$xml->command('alert', array('message' => "Sorry, the $field '" . stripslashes($value) . "' is already in use!")); 
	$xml->command('setdefault', array('target' => "field_{$field}")); 
	$xml->command('focus', array('target' => "field_{$field}"));
   }
    $xml->end();
echo SELECT COUNT(*) AS count FROM $table WHERE $field='$value';
?>
