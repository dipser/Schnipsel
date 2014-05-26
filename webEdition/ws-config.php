<?
/**
 * Die Sprachvariablen werden hier zugeordnet:
 *
 * Verwendung als: $ws_BEGRIFF
 */
$ws = array('DE'=>array(), 'EN'=>array(), 'NL'=>array());

$ws['DE'] = array(
	'langName' => 'English',
	'index' => 3160,
	'navMain' => 105
);
$ws['EN'] = array(
	'langName' => 'English',
	'index' => 3160,
	'navMain' => 105
);
$ws['NL'] = array(
	'langName' => 'Nederlands',
	'index' => 3180,
	'navMain' => 106
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

// Workspaces
foreach ($ws[strtoupper($lng)] as $key => $val) {
	${'ws_'.$key} = $val; // => $ws_index
}

?>
<we:ifWorkspace id="2421" comment="EN"><? $isLng = true; ?></we:ifWorkspace>
<we:ifWorkspace id="2422" comment="NL"><? $isLng = true; ?></we:ifWorkspace>