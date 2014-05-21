
<?
/**
 * Workspaces
 */


// Workspace 1
$daten1 = array(
  'root' => 0,
  'de_space' => 106, // Standard-Workspace
  'en_space' => 851,
  'favicon' => 753
);

// Workspace 2
$daten2 = array(
  'root' => 905,
  'de_space' => 906,
  'en_space' => 1027,
  'favicon' => 999
);


// Sprache
$lng = we_tag('pageLanguage', array('type'=>'language', 'case'=>'lowercase')); // "de" oder "en"


// Workspace zuordnung
$ws = $daten1;
$daten2root = $daten2['root'];
?><we:ifWorkspace id="$daten2root"><? $ws = $daten2; ?></we:ifWorkspace><?



// Array in Vars umwandeln: $ws_*
foreach ($ws as $key => $val) {
  ${'ws_'.$key} = $val;
}

?>