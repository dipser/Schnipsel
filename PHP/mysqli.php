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


?>
