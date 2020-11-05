<?php

$dbhost = 'localhost';
$dbname = '';
$dbuser = '';
$dbpass = '';


$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_error) {
    exit;//die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}


$mysqli->real_escape_string("...");


$mysqli->query($sql);


$result = $mysqli->query($sql);
if ( $row = $result->fetch_object() ) {
  echo $row->feldname;
}


$result = $mysqli->query($sql);
while ( $row = $result->fetch_object() ) {
    echo $row->feldname;
}


$mysqli->insert_id;


$mysqli->affected_rows;


// Mysqli prepared query
// Usage: mysqli_prepared_query($mysqli, $sql, 'sss', ['a', 'b', 'c'])
function mysqli_prepared_query($mysqli, $sql, $bind_types = '', $bind_params = []){
    $result = false;
    $stmt = $mysqli->prepare($sql);
    if ( $stmt ){
        if ( !empty($bind_params) ) { $stmt->bind_param($bind_types, ...$bind_params); } // replace "?"
        $stmt->execute();
        $result = $stmt->get_result();
    }
    return $result;
}




// Wildcard (*) SELECTs
$mysqli = $GLOBALS['mysqli'];
$stmt = $mysqli->prepare("SELECT * FROM tablename WHERE id=?");
if ( $stmt ) {
	$stmt->bind_param('i', $id); // Fragezeichen (?) ersetzen
	$stmt->execute(); // SQL-Query ausführen
	
	// Alle Felder auslesen:
	$meta = $stmt->result_metadata();
	while ($field = $meta->fetch_field()) {
		$parameters[] = &$row[$field->name];
	}
	call_user_func_array(array($stmt, 'bind_result'), $parameters);
	while ($stmt->fetch()) {
		foreach($row as $key => $val) {
			$x[$key] = $val;
		}
		$results[] = $x;
	}
	
	// Daten als Eigenschaft ablegen:
	$data = $results[0];
}

?>
