<?php

// Datenbank Einstellung
define('DBHOST', 'localhost');
define('DBPORT', 8889);
define('DBNAME', 'db');
define('DBUSER', 'root');
define('DBPASS', 'root');

// PDO Verbindung aufbauen
$GLOBALS['pdo'] = $pdo = new PDO('mysql:host='.DBHOST.';port='.DBPORT.';dbname='.DBNAME.';charset=utf8', DBUSER, DBPASS, array( PDO::ATTR_PERSISTENT => false));


// Listenausgabe
$sql = 'SELECT * FROM tablename WHERE userid = :userid';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->rowCount(); // Anzahl
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    echo $row->id.'<br />';
}


// Inserting
$sql = 'INSERT INTO tablename (column) VALUES (:val)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':val', $val, PDO::PARAM_INT);
$stmt->execute();
echo $lastId = $pdo->lastInsertId();

// UPDATE sonst INSERT
$sql = 'INSERT INTO `tablename` (id, val) VALUES (:id, :val) ON DUPLICATE KEY UPDATE val = :val';
$stmt = $pdo->prepare($sql);
$id = 1;
$val = time();
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':val', $val, PDO::PARAM_INT);
$stmt->execute();


// SELECT
$sql = 'SELECT * FROM `tablename` WHERE val = :val';
$stmt = $pdo->prepare($sql);
$val = time();
$stmt->bindParam(':val', $val, PDO::PARAM_INT);
$stmt->execute();
if ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
	echo $row->cellname.'<br />';
}


// TRUNCATE
$sql = 'TRUNCATE TABLE `tablename`';
$stmt = $pdo->prepare($sql);
$stmt->execute();


?>
