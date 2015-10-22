<?php

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
  echo '<div>MySQLi ist nicht installiert!</div>';
} else {
  echo '<div>Läuft bei uns - MySQLi ist installiert!</div>';
}

if (!defined('PDO::ATTR_DRIVER_NAME')) {
	echo '<div>PDO ist nicht installiert!</div>';
} else {
	echo '<div>Läuft bei uns - PDO ist installiert!</div>';
}

?>
