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

// 
$text = asciiOnly('äüö_-as');


// IDs und Pfade ermitteln
// <we:url id="9" />
$path = id_to_path(9);

$id = path_to_id('/subdir');

$id = f('SELECT ID FROM '. FILE_TABLE .' WHERE Path="'. $GLOBALS['DB_WE']->escape($we_doc->Path) .'"', 'ID', $GLOBALS['DB_WE'])


// Print Array mit Formatierung
p_r($we_doc);
p_r($GLOBALS['we_doc']);

    <?php $GLOBALS['we_doc']->setElement('Headline', 'Das ist ein Beispieltext.'); ?>
    //<we:input type="text" name="Headline"/>
    $GLOBALS['we_doc']->setElement('Headline');

// Daten der Überseite in der <we:include type="document" id="" /> steht
p_r($GLOBALS['WE_MAIN_DOC']);


// <we:... />
we_tag( string $name , array $attribs [, string $content] );


//
$GLOBALS['we_doc']->setElement('Headline', 'Das ist ein Beispieltext.');
//<we:input type="text" name="Headline"/>
$GLOBALS['we_doc']->getElement('Headline');



makeArrayFromCSV($csv);
makeCSVFromArray($arr, $prePostKomma=false, $sep=",")


// Seite laden 
$content = getHTTP($server, $url, $port="", $username="", $password="");




// Glossa-Ersetzung
$content = we_glossary_replace::doReplace($content, $GLOBALS['we_doc']->Language);


/**
 * - error_log2($variable) // Schreibt beliebige Variablen, Arrays und Objekte, auch verschachtelt, in die PHP-Error-Log-Datei. 
 * - removePHP( string $val )
 * - removeHTML($val)
 */
 
##################################################################
###### NOCH TESTEN...
 

    weFile::load($filename, $flags="rb", $rsize=8192)
    weFile::save($filename, $content, $flags="wb", $create_path=false)
    weFile::delete($filename)
    weFile::saveTemp($content, $filename="", $flags="wb"


//returns array of directory IDs of all directories which are located inside $folderID (recursive)
we_util::getFoldersInFolder($folderID, $table = FILE_TABLE, $db = '')


//we_global.inc.php

in_parentID($id, $pid, $table = FILE_TABLE, $db = '')

in_workspace($IDs, $wsIDs, $table = FILE_TABLE, $db = '', $objcheck = false)

getHrefForObject($id, $pid, $path = '', $DB_WE = '', $hidedirindex = false, $objectseourls = false)

we_getDocumentByID($id, $includepath = '', $we_getDocumentByIDdb = '', &$charset = '')
we_getObjectFileByID($id, $includepath = '')

getServerProtocol($slash = false)


// This function creates the given path in the repository and returns the id of the last created folder
function makePath($path, $table, &$pathids, $owner = 0)

//This function clears path from double slashes and back slashes
clearPath($path)

we_isHttps()


?>
