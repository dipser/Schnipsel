<?php

$we_ContentType = getContentTypeFromFile($filename);

WE_INCLUDES_PATH

TEMP_PATH

weFile::getUniqueId()

importFunctions::correctFilename($filename)

$file_id = f('SELECT ID FROM ' . FILE_TABLE . ' WHERE
Path="' . $GLOBALS['DB_WE']->escape($we_doc->Path) . '"', 'ID',
$GLOBALS['DB_WE'])


$we_doc->initByID($file_id, FILE_TABLE);
$we_doc->setParentID(123);
$we_doc->Filename = preg_replace('/^(.+)\..+$/', "\\1", $_fn);
$we_doc->Extension = (stristr($_fn, ".") ?
strtolower(preg_replace('/^.+(\..+)$/', "\\1", $_fn)) : '');
$we_doc->Text = $footext;
$we_doc->Filename = $we_doc->Filename . "_" . $z;
$we_doc->Path

$we_doc->setElement("type", $we_ContentType, "attrib");






// http://forum.webedition.org/viewtopic.php?f=87&t=40036

$filename = 'http://domain.de/Odin.JPG';
$filedata = file_get_contents($filename);
$parentid = 5551;


$img = new we_imageDocument();
$pathinfo = pathinfo($filename);
$img->Filename = $pathinfo['filename']; // Ohne Dateiendung
$img->Extension = '.'.strtolower($pathinfo['extension']);
$img->Text = $img->Filename.$img->Extension;
$img->Path = id_to_path($parentid) .'/'. $img->Text;
$fileserverpath = $_SERVER['DOCUMENT_ROOT'].$img->Path;
file_put_contents($fileserverpath, $filedata);
$img->setParentID($parentid); // Ziel-Verzeichnis
$img->setElement("filesize", filesize($fileserverpath), "attrib");
$img->setElement("type", getContentTypeFromFile($filename), "attrib");
$img->Table = FILE_TABLE;
$img->Published = time();
$img->DocChanged = true;
$img->setElement('data', $fileserverpath, 'image');
$img->we_save();
//echo $img->ID;

//p_r($img);





//$img2 = new we_imageDocument();
//$img2->initByID( 5285 );
//p_r($img2);
?>




