<?php

/**
 * webEdition Objekt öffnen
 */
 

// Neues Objekt öffnen
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
$objpath = '/classdir';
$obj = new we_objectFile();
$obj->we_new();
$obj->TableID = 10; //ID der Klasse
$obj->setRootDirID(true);
$obj->restoreDefaults();
//$obj->add_workspace($wsid);
//$obj->del_workspace($wsid);
//$obj->Workspaces = ''; // Reset
//$obj->Templates = '';
$obj->Text = 'Objektname';
$obj->Path = $objpath.'/'.$obj->Text;
$obj->getElement('NameObjektFeld');
$obj->setElement('NameObjektFeld', 'Wert');
$obj->setElement('ObjektFelder', serialize(array(
	'class'   => 9, // Klassen-ID / SQL-Tabellen-Nummer
	'max'     => 0,
	'objects' => array(1,2,3) // Alle IDs auf die verwiesen werden soll
)));
$obj->we_save();
$obj->we_publish();
$createdID = $obj->ID;

//$obj->Published // 0 oder time()




// Vorhandenes Objekt öffnen
$id = 123;
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
$obj = new we_objectFile();
$obj->initByID($id);
$obj->getElement('NameObjektFeld');
$obj->setElement('NameObjektFeld', 'Wert');
$obj->we_save();
$obj->we_publish(); 




// Kopieren
$obj->makeSameNew();





$obj = new we_objectFile();
$obj->initByID(497);
$object->we_new();
$object->TableID = 19;
$object->setRootDirID(true);
$object->resetParentID();
$object->restoreDefaults();
$object->Text = $rechnungsnummer;
$object->Path=$object->getParentPath()
// ...
$object->we_save();
$object->we_publish();





// Objekt löschen
$GLOBALS['NOT_PROTECT'] = (bool) true; // Sicherheitssperre aufheben, damit keine webEdition-Session benötigt wird
include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_delete_fn.inc.php';
deleteEntry($id, OBJECT_FILES_TABLE); // Objekt mit der angegebenen ID löschen
if (isset($deletedItems)) { print_r($deletedItems); } // Ausgabe aller gelöschten Objekte


?>




<?php
// Objekt ändern
?>
<?php
	$_REQUEST['edit_object'] = 1; // Achtung WebEdition, es soll ein Objekt geändert werden!
	$_REQUEST['we_editObject_ID'] = $hier_deine_objekt_id; // ID des zu ändernden Objekts - gaht natürlich auch dynamisch
	$_REQUEST['we_ui_we_global_form']['MeinFeld'] = $_REQUEST['we_ui_we_global_form']['MeinFeld'] - 1; // der Rest wie oben
?>
<we:write type="object" publish="true" classid="XXX" forceedit="true" />
<we:ifWritten type="object">Objekt gespeichert!</we:ifWritten>


<?php
// Alle Klassen zurückgeben:
function getAllClassesByPath() {
	$classes = array();
	$db = $GLOBALS['DB_WE'];
	$db->query("SELECT ID,Path FROM " . OBJECT_TABLE . " ORDER By ID");
	while ($db->next_record()) {
		$classes[] = array('ID'=>$db->f("ID"), 'Path'=>$db->f("Path"));
	}
	return $classes;
}
p_r(getAllClassesByPath());




// Meta
	$db->query("SELECT DefaultValues,Path FROM ". OBJECT_TABLE ." WHERE ID = ".$ID);
	$db->next_record();
	$Meta = unserialize($db->f("DefaultValues"));
	$Meta = $Meta['meta_Kategorie']['meta'];
	$Path = $db->f("Path");
	
// Klassen-Ordner
$root = f("SELECT ID FROM tblObjectFiles WHERE IsClassFolder = 1 AND Path = '/POI'", 'ID', $GLOBALS['DB_WE']);

?>
