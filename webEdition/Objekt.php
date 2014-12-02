<?php

/**
 * webEdition Objekt öffnen
 */

// (Neues) Objekt öffnen
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
$objpath = '/classdir';
$obj = new we_objectFile();
$obj->we_new(); // Alternativ: $obj->initByID(497);
$obj->TableID = 10; //ID der Klasse
$obj->setRootDirID(true);
$obj->resetParentID();
$obj->restoreDefaults();
//$obj->setParentID($ParentID); // ID eines Unterverzeichnisses (nötig?)
//$obj->add_workspace($wsid); // Arbeitsbereich hinzufügen
//$obj->del_workspace($wsid);
//$obj->Workspaces = ''; // Arbeitsbereich: Reset
//$obj->Templates = '';
$obj->Text = importFunctions::correctFilename('Objekt Name');
$obj->Path = $obj->getParentPath() . (($obj->getParentPath() != "/") ? "/" : "") . $obj->Text;
$obj->getElement('NameObjektFeld');
$obj->setElement('NameObjektFeld', 'Wert');
$obj->setElement('ObjektFelder', serialize(array( // Multi-Objekt
	'class'   => 9, // Klassen-ID / SQL-Tabellen-Nummer
	'max'     => 0,
	'objects' => array(1,2,3) // Alle IDs auf die verwiesen werden soll
)));
$obj->setElement('we_object_1', 6); // Einzel-Objekt
$obj->we_save(); $obj->we_publish(); // Bei neuem Objekt.
//$obj->PublWhenSave = 1; $obj->we_save(1); // Bei altem Objekt. / 1=Resave
$createdID = $obj->ID;

//$obj->Published // 0 oder time()




// Neues Objekt anlegen (alternativ)
$obj = we_objectFile::initObject($classID);
$obj->Text = 'Objekt-Name';
$obj->Path = $obj->getParentPath() . (($obj->getParentPath() != "/") ? "/" : "") . $obj->Text;
$obj->setElement("xyz", $xyz);
$obj->we_save();
$obj->we_publish();



// Kopieren
$obj->makeSameNew();





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







	// Objekt erstellen (Kurzversion)
	$objfields = array(
		'Titel' 	=> $title, 
		'Beschreibung' 	=> $text
	);
	$categories		=	''; // '' = keine Kategorie / ',1,' = eine Kategorie / ',1,2,' = 2 Kategorien
	$rcd_name 		= 	importFunctions::correctFilename($title); // der Name des neuen Objektes
	$publish = true;
	$collision		=	"replace"; // replace = überschreibt vorhandene Objekte mit gleichem namen / rename = erstellt immer neues objekt mit Endung "_X"
	importFunctions::importObject($classid, $objfields, $categories, $rcd_name, $publish, $collision); // webEdition/we/include/we_import/importFunctions.class.inc.php
	//importObject($classID, $fields, $categories = "", $filename = "", $publish = true, $conflict = 'rename')
	//Neu 6.3.9(?): we_import_functions::importObject($classID, $fields, $categories, $filename, $publish, $issearchable);

	// Objekt löschen
	deleteEntry($object_id, OBJECT_FILES_TABLE);

?>
