<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_webEditionDocument.inc.php';
$doc = new we_webEditionDocument();
$doc->initByID(9);
$doc->getElement('Headline');
$doc->setElement('Headline', 'Wert');
$doc->we_save();
$doc->we_publish();









echo $GLOBALS['we_doc']->getElement("Title");
echo $GLOBALS['we_doc']->getElement("Description");

echo $GLOBALS['we_doc']->OF_ID;
echo $GLOBALS['we_doc']->TableID;


// Die ID der Vorlage auf der das webEdition-Dokument basiert
echo $GLOBALS['we_doc']->TemplateID;

// Der Pfad der Vorlage auf der das webEdition-Dokument basiert
echo $GLOBALS['we_doc']->TemplatePath;

// Die ID des webEdition-Dokuments
// <we:did />
echo $GLOBALS['we_doc']->ID;

// Die ID des Verzeichnisses in dem sich das webEdition-Dokument befindet
echo $GLOBALS['we_doc']->ParentID;

// Der Pfad des webEdition-Dokuments
echo $GLOBALS['we_doc']->Path;

// Der Pfad des Verzeichnisses in dem sich das webEdition-Dokument befindet
echo $GLOBALS['we_doc']->ParentPath;

// Ist das webEdition-Dokument statisch oder dynamisch abgespeichert?
echo $GLOBALS['we_doc']->IsDynamic; // 0 = statisch; 1 = dynamisch

// Ist das webEdition-Dokument durchsuchbar?
echo $GLOBALS['we_doc']->IsSearchable; // 0 = nicht durchsuchbar; 1 = durchsuchbar

// Dateiname mit Dateierweiterung des webEdition-Dokuments
echo $GLOBALS['we_doc']->Text;

// Dateiname ohne Dateierweiterung des webEdition-Dokuments
echo $GLOBALS['we_doc']->Filename;

// Dateierweiterung des webEdition-Dokuments
echo $GLOBALS['we_doc']->Extension;

// Dokument Typ des webEdition-Dokuments (bis webEdition 1.5.2)
echo $GLOBALS['we_doc']->DocType;

// Dokument Typ des webEdition-Dokuments (ab webEdition 2.0)
$ThisDocType = (string) f("SELECT DocType FROM ".DOC_TYPES_TABLE." WHERE ID = '".$GLOBALS['we_doc']->DocType."'", 'DocType', $GLOBALS['DB_WE']);
echo $ThisDocType;

// ID(s) der Kategorie(n) des webEdition-Dokuments
$categories = (string) $GLOBALS['we_doc']->Category;  // alle IDs in einem String durch Komma getrennt
$a_categories = explode(',', $categories); // String teilen und in eine Array schreiben
$aa_categories = array_slice($a_categories, 1, -1); // führendes und letztes Komma entfernen
p_r($a_categories);

// Erstellungsdatum des webedition-Dokuments
echo $GLOBALS['we_doc']->CreationDate;

// Veröffentlichungsdatum des webedition-Dokuments
echo $GLOBALS['we_doc']->Published;

// Letzte Änderung des webEdition-Dokuments
echo $GLOBALS['we_doc']->ModDate;

// ID des Benutzers, der das webEdition-Dokument angelegt hat
echo $GLOBALS['we_doc']->CreatorID;

// ID des Benutzers, der das webEdition-Dokument zuletzt geändert hat
echo $GLOBALS['we_doc']->ModifierID;




?>
