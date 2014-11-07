<?php

/**
 * webEdition Bild-Dokument öffnen
 */


$img = new we_imageDocument();
$img->initByID( 5285 );
p_r($img);
//$img->we_save();





function uploadFile($file,$parentid)
{   
   // übergeben wird ein $_FILE-Objekt, also z.B. $_FILE['upload']

   // Extension ermitteln
   $pathinfo = pathinfo($file['name']);
   $ext = strtolower($pathinfo['extension']);
   
   $path = $file['tmp_name'];
   $filedata = file_get_contents($path);
   
   // Filename
   $filename = md5(userVal('id').time()); // wird in meinem Fall verschlüsselt
   
   if(isImage($file)) $doc = new we_imageDocument();
   else $doc = new we_otherDocument();
   
   $doc->Filename = $filename;
   $doc->Extension = '.'.$ext;
   $doc->Text = $doc->Filename.$doc->Extension;
   $doc->Path = id_to_path($parentid) .'/'. $doc->Text;
   $fileserverpath = $_SERVER['DOCUMENT_ROOT'].$doc->Path;
   file_put_contents($fileserverpath, $filedata);
   $doc->setParentID($parentid);
   $doc->setElement("filesize", filesize($fileserverpath), "attrib");
   $doc->setElement("type", getContentTypeFromFile($path), "attrib");
   $doc->Table = FILE_TABLE;
   $doc->DocChanged = true;
   $doc->we_save();
   return $doc->ID;
}

?>
