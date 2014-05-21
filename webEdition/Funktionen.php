<?php

/**
 * webEdition standalone functions
 */


// webEdition Dokument Dateityp-Erkennung
$we_ContentType = getContentTypeFromFile($filename);


// Unique ID
weFile::getUniqueId()


// Dateinamen für webEdition anpassen
importFunctions::correctFilename($filename)


// IDs und Pfade ermitteln
$path = id_to_path(9);

$id = path_to_id('/subdir');

$id = f('SELECT ID FROM '. FILE_TABLE .' WHERE Path="'. $GLOBALS['DB_WE']->escape($we_doc->Path) .'"', 'ID', $GLOBALS['DB_WE'])


// Print Array mit Formatierung
p_r($we_doc);



?>