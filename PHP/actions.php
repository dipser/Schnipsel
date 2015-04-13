<?php
/**
 * Seitenübergreifende Formularverarbeitung
 */


// Sonderfall: Action-Variable setzen für Logout
if ( isset($_GET['action']) && $_GET['action']=='logout' ) {
	$_POST['action'] = 'logout';
}


// Rückmeldevariable erstellen
$action = isset($_POST['action']) ? $_POST['action'] : '';
if ( isset($_POST['action']) ) {
	$announcement = array();
	$announcement['action'] = $action;
	$announcement['status'] = false;
}

// Array zu GET-Querystring
function announcement_query($announcement) {
	return urldecode(http_build_query(array('announcement'=>$announcement)));
}



/**
 * Action 1 - Langsamere Variante
 */
if ( $action == 'demologin' ) {
	if ( !empty($_POST['human']) ) {

		// ...
		
		$announcement['status'] = true;
		header('Location: '.$_SERVER['PHP_SELF'].'?'.announcement_query($announcement));
		exit;
	}
}


/**
 * Action 2 - Schnelle Variante
 */
if ( $action == 'demologin' ) {
	include 'actions/action2.php';
}



// Fehlerrückmeldung über GET
if ( isset($_POST['action']) ) {
	$_GET['announcement'] = $announcement;
	unset($announcement);
}
?>
