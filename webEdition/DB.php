<?php


$db = new DB_WE();
$db->escape($unsafe_variable); // Sanitizing data
$db->query("SELECT Path FROM " . FILE_TABLE . " WHERE IsFolder=0 ORDER By ID");
print "Anzahl Zeilen: " . $db->num_rows() . "<br>";
while ($db->next_record()) {
	print $db->f("Path") . "<br>";
}


?>
