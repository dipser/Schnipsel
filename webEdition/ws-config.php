<?
/**
 * Die Sprachvariablen werden hier zugeordnet:
 *
 * Verwendung als: $ws_BEGRIFF
 */
$ws = array();
$ws['DE'] = array(
	'langName' => 'English',
	'index' => 1, // Startseite
	'navMain' => 1, // Hauptnavigation
	'heute' => strtotime(date('Y-m-d')), // Heutiger Tag ab Stunde 0
	'editmode' => $GLOBALS['we_editmode'],
	'tag' => array("", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag"),
	'tagAbk' => array("", "Mo", "Di", "Mi", "Do", "Fr", "Sa", "So"),
	'monat' => array("", "Januar","Februar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"),
	'monatAbk' => array("", "Jan","Feb","M&auml;r","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez")
);
$ws['EN'] = array(
	'langName' => 'English',
	'index' => 2,
	'navMain' => 2
);
$ws['NL'] = array(
	'langName' => 'Nederlands',
	'index' => 3,
	'navMain' => 3
);

$ws['DE']['Startseite'] = 'Startseite';
$ws['EN']['Startseite'] = 'Homepage';
$ws['NL']['Startseite'] = 'Thuis';

$ws['DE']['Suchbegriff'] = 'Suchbegriff';
$ws['EN']['Suchbegriff'] = 'Keyword';
$ws['NL']['Suchbegriff'] = 'Trefwoord';

$ws['DE']['Suchen'] = 'Suchen';
$ws['EN']['Suchen'] = 'Search';
$ws['NL']['Suchen'] = 'Zoeken';

// ...


// Glossarbegriffe (Aufruf: echo glossar('Wort');)
$ws_glossar = array(
	//'Wort' => array('DE'=>'DeutWort', 'EN'=>'EnglWort', 'NL'=>'NiedWort'),
	//...
);





/******************************************************************************
 * Ab Hier nichts mehr bearbeiten.
 */
$lng = we_tag('pageLanguage', array('type'=>'language', 'doc'=>'top', 'case'=>'lowercase'));

// Glossarersetzung
function glossar($wort) {
	global $ws_selectwords, $lng;
	if (array_key_exists($wort, $ws_selectwords)) {
		return $ws_selectwords[$wort][strtoupper($lng)];
	}
	return $wort;
}

// Workspaces / Sprachen
foreach ($ws[strtoupper($lng)] as $key => $val) {
	${'ws_'.$key} = $val; // => $ws_index
}
unset($ws);

?>
