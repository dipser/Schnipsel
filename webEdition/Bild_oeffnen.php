<?php
// Version 1

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


<?php
// Version 2

$parentid = 264;
$filesource = $url;
$filesource = 'http://img-9gag-ftw.9cache.com/photo/avg1oxE_700b_v1.jpg';
$filesource = 'http://img-9gag-ftw.9cache.com/photo/1075953_700b.jpg';

$filedata = @file_get_contents($filesource);
if ($filedata != false) {
	$img = new we_imageDocument();
	$pathinfo = pathinfo($filesource);
	//p_r($pathinfo);
	
	$filepath = id_to_path($parentid).'/'.$pathinfo['filename'].'.'.strtolower($pathinfo['extension']);
	$fileid = path_to_id( $filepath );
	//p_r(array($fileid, $filepath));
	if ( $fileid>0 ) { // Datei existiert schon -> Überschreiben
		$img->initByID( $fileid );
	}
	//p_r($img);
	
	$img->Filename = ($newfilename==false) ? $pathinfo['filename'] : $newfilename; // Ohne Dateiendung
	$img->Extension = '.'.strtolower($pathinfo['extension']);
	$img->Text = $img->Filename.$img->Extension;
	$img->Path = id_to_path($parentid) .'/'. $img->Text;
	$fileserverpath = $_SERVER['DOCUMENT_ROOT'].$img->Path;
	file_put_contents($fileserverpath, $filedata);
	$img->setParentID($parentid); // Ziel-Verzeichnis
	$img->setElement("filesize", filesize($fileserverpath), "attrib");
	$img->setElement("type", getContentTypeFromFile($filesource), "attrib");
	list($width, $height) = getimagesize($fileserverpath);
	$img->setElement("width", $width, "attrib");
	$img->setElement("height", $height, "attrib");
	$img->Table = FILE_TABLE;
	$img->Published = time();
	$img->DocChanged = true;
	$img->setElement('data', $fileserverpath, 'image');
	$img->we_save();
	
	//p_r($img);
	
	echo $img->ID;
	
}
?>
