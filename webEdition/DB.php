<?php


//$db = new DB_WE();
$db = $GLOBALS['DB_WE'];
$db->escape($unsafe_variable); // Sanitizing data
$db->query("SELECT Path FROM " . FILE_TABLE . " WHERE IsFolder=0 ORDER By ID");
print "Anzahl Zeilen: " . $db->num_rows() . "<br>";
echo $db->num_rows();
while ($db->next_record()) {
	print $db->f("Path") . "<br>";
}




getHash($query, $DB_WE, MYSQL_ASSOC)


?>
