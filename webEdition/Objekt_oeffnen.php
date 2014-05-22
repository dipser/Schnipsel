<?php

/**
 * webEdition Objekt öffnen
 */

// INIT OBJECT
$obj = new we_objectFile();
$obj->we_new();
$obj->TableID = 10; //ID der Klasse
$obj->setRootDirID(true);
$obj>restoreDefaults();
$obj->setElement('NameObjektFeld', 'Wert');
$obj->setElement('NameObjektFeld2', 'Wert');
// webEdition-Seite speichern
$obj->we_save();
// webEdition-Seite veröffentlichen
$obj->we_publish();


> $obj = new we_objectFile();
> $obj->initByID($eineID);
> $obj->setElement('Veroeffentlicht', '1');
> $obj->setElement('LetzterBeitrag', $zeitstempel);
> $obj->we_save();
> $obj->we_publish(); 

?>