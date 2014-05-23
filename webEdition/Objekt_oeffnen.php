<?php

/**
 * webEdition Objekt öffnen
 */
 

// Neues Objekt öffnen
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once($_SERVER "DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
$objpath = '/classdir';
$obj = new we_objectFile();
$obj->we_new();
$obj->TableID = 10; //ID der Klasse
$obj->setRootDirID(true);
$obj>restoreDefaults();
$obj->Text = 'Objektname';
$obj->Path = $objpath.'/'.$obj->Text;
$obj->setElement('NameObjektFeld', 'Wert');
$obj->we_save();
$obj->we_publish();



// Vorhandenes Objekt öffnen
$id = 123;
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once($_SERVER "DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
$obj = new we_objectFile();
$obj->initByID($id);
$obj->setElement('NameObjektFeld', 'Wert');
$obj->we_save();
$obj->we_publish(); 

?>
