<?php

p_r(DB_HOST);
p_r(DB_DATABASE);
p_r(DB_USER);
p_r(DB_PASSWORD);

// MySQLi Verbindung
$GLOBALS['mysqli'] = $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// PDO Verbindung
$GLOBALS['pdo'] = $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';charset=utf8', DB_USER, DB_PASSWORD, array( PDO::ATTR_PERSISTENT => false));


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




// Andere DB-Verbindung aufbauen mit webEdition geht nicht.



?>
