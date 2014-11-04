<?php


//$db = new DB_WE();
$db = $GLOBALS['DB_WE'];
$db->escape($unsafe_variable); // Sanitizing data
$db->query("SELECT Path FROM " . FILE_TABLE . " WHERE IsFolder=0 ORDER By ID");
echo 'Anzahl Zeilen: ' . $db->num_rows() . '<br>';
//echo 'Anzahl geänderter Zeilen: ' . $db->affected_rows() . '<br>';
while ($db->next_record()) {
	print $db->f("Path") . "<br>";
}




getHash($query, $DB_WE, MYSQL_ASSOC)
f($query, $field, $DB_WE)



$tableInfo = $DB_WE->metadata($table);
	$fn = array();
	foreach($tableInfo as $t){
		$fieldName = $t['name'];
		$fn[$fieldName] = isset($hash[$fieldName . '_autobr']) ? nl2br($hash[$fieldName]) : $hash[$fieldName];
	}




// Andere DB-Verbindung aufbauen mit webEdition
// Siehe: class DB_WE extends we_database_base {}
$database = 'database2';
$host = 'localhost';
$user = 'user';
$pass = 'pass';
$GLOBALS['DB_WE_xyz']->connect($database, $host, $user, $pass);
//p_r($GLOBALS['DB_WE_xyz']);


?>
