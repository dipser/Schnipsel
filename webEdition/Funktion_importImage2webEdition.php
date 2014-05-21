<?php
function importImage2webEdition($parentid, $filesource, $newfilename = false) {
	$filedata = @file_get_contents($filesource);
	if ($filedata != false) {
		$img = new we_imageDocument();
		$pathinfo = pathinfo($filesource);
		$img->Filename = ($newfilename==false) ? $pathinfo['filename'] : $newfilename; // Ohne Dateiendung
		$img->Extension = '.'.strtolower($pathinfo['extension']);
		$img->Text = $img->Filename.$img->Extension;
		$img->Path = id_to_path($parentid) .'/'. $img->Text;
		$fileserverpath = $_SERVER['DOCUMENT_ROOT'].$img->Path;
		file_put_contents($fileserverpath, $filedata);
		$img->setParentID($parentid); // Ziel-Verzeichnis
		$img->setElement("filesize", filesize($fileserverpath), "attrib");
		$img->setElement("type", getContentTypeFromFile($filesource), "attrib");
		$img->Table = FILE_TABLE;
		$img->Published = time();
		$img->DocChanged = true;
		$img->setElement('data', $fileserverpath, 'image');
		$img->we_save();
		return $img->ID;
	}
	return false;
}



//$parentid = 5551;
//$filesource = 'http://www.domain.de/bild.jpg';
//importImage2webEdition($parentid, $filesource);


// Thumbnails: http://forum.webedition.org/viewtopic.php?f=87&t=13836

?>
