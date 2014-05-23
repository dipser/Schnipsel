<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_webEditionDocument.inc.php';
$doc = new we_webEditionDocument();
$doc->initByID(9);
$doc->getElement('Headline');
$doc->setElement('Headline', 'Wert');
$doc->we_save();
$doc->we_publish();





Beispiel #1 - Die ID der Vorlage auf der das webEdition-Dokument basiert

<?php echo $GLOBALS['we_doc']->TemplateID; ?>

Beispiel #2 - Der Pfad der Vorlage auf der das webEdition-Dokument basiert

<?php echo $GLOBALS['we_doc']->TemplatePath; ?>

Beispiel #3 - Die ID des webEdition-Dokuments

<?php echo $GLOBALS['we_doc']->ID; ?>

Beispiel #4 - Die ID des Verzeichnisses in dem sich das webEdition-Dokument befindet

<?php echo $GLOBALS['we_doc']->ParentID; ?>

Beispiel #5 - Der Pfad des webEdition-Dokuments

<?php echo $GLOBALS['we_doc']->Path; ?>

Beispiel #6 - Der Pfad des Verzeichnisses in dem sich das webEdition-Dokument befindet

<?php echo $GLOBALS['we_doc']->ParentPath; ?>

Beispiel #7 - Ist das webEdition-Dokument statisch oder dynamisch abgespeichert?

<?php
  echo $GLOBALS['we_doc']->IsDynamic;
  /* 0 = statisch */
  /* 1 = dynamisch */
?>



Beispiel #8 - Ist das webEdition-Dokument durchsuchbar?

<?php
  echo $GLOBALS['we_doc']->IsSearchable;
  /* 0 = nicht durchsuchbar */
  /* 1 = durchsuchbar */
?>

Beispiel #9 - Dateiname mit Dateierweiterung des webEdition-Dokuments

<?php echo $GLOBALS['we_doc']->Text; ?>

Beispiel #10 - Dateiname ohne Dateierweiterung des webEdition-Dokuments

<?php echo $GLOBALS['we_doc']->Filename; ?>

Beispiel #11 - Dateierweiterung des webEdition-Dokuments

<?php echo $GLOBALS['we_doc']->Extension; ?>

Beispiel #12 - Dokument Typ des webEdition-Dokuments (bis webEdition 1.5.2)

<?php echo $GLOBALS['we_doc']->DocType; ?>



Beispiel #13 - Dokument Typ des webEdition-Dokuments (ab webEdition 2.0)

<?php
  $sql = (string) "SELECT DocType FROM ".DOC_TYPES_TABLE." WHERE ID = '".$GLOBALS['we_doc']->DocType."'";
  $ThisDocType = (string) f($sql, 'DocType', $GLOBALS['DB_WE']);
  echo $ThisDocType;
?>

Beispiel #14 - ID(s) der Kategorie(n) des webEdition-Dokuments

<?php
  // alle IDs in einem String durch Komma getrennt
  $categories = (string) $GLOBALS['we_doc']->Category;
  // String teilen und in eine Array schreiben
  $a_categories = explode(',', $categories);
  // führendes und letztes Komma entfernen
  $aa_categories = array_slice($a_categories, 1, -1);
  // Ausgabe
  p_r($a_categories);
?>

Beispiel #15 - Erstellungsdatum des webedition-Dokuments

<?php echo $GLOBALS['we_doc']->CreationDate; ?>

Beispiel #16 - Veröffentlichungsdatum des webedition-Dokuments

<?php echo $GLOBALS['we_doc']->Published; ?>

Beispiel #17 - Letzte Änderung des webEdition-Dokuments

<?php echo $GLOBALS['we_doc']->ModDate; ?>

Beispiel #18 - ID des Benutzers, der das webEdition-Dokument angelegt hat

<?php echo $GLOBALS['we_doc']->CreatorID; ?>

Beispiel #19 - ID des Benutzers, der das webEdition-Dokument zuletzt geändert hat

<?php echo $GLOBALS['we_doc']->ModifierID; ?>




?>
