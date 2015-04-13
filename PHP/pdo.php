<?php

// Datenbank Einstellung
define('DBHOST', 'localhost');
define('DBPORT', 8889);
define('DBNAME', 'db');
define('DBUSER', 'root');
define('DBPASS', 'root');

// PDO Verbindung aufbauen
$GLOBALS['pdo'] = $pdo = new PDO('mysql:host='.DBHOST.';port='.DBPORT.';dbname='.DBNAME, DBUSER, DBPASS, array( PDO::ATTR_PERSISTENT => false));


// Listenausgabe
$sql = 'SELECT * FROM tablename WHERE userid = :userid';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->rowCount(); // Anzahl
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    echo $row->id.'<br />';
}



?>
