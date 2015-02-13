<?php
// Pfad: /webEdition/we/include/we_hook/custom_hooks/weCustomHook_save.inc.php
// http://forum.webedition.org/viewtopic.php?f=120&t=40066
function weCustomHook_save($param){
	$hookHandler = $param['hookHandler'];
	$resave = $param['resave'];
	$obj = $param[0];
	switch(get_class($obj)){
		// Mitspeichern der Master-Datei, bei Speicherung von Less/SCSS-Dateien aus den Ordnern $lesspath
		case 'we_textDocument':
			$parentpath = array(21,22); // <= IDs aller Elternordner
			if ( in_array($obj->ParentID, $parentpath) && in_array($obj->Extension, array('.less','.scss')) && ($obj->parseFile == false) ) {
				$aMasterIDs = array(10); // <= ID der main.less, main.scss
				foreach($aMasterIDs as $iID) {
					$masterfile = new we_textDocument();
					$masterfile->initByID($iID);
					$masterfile->we_save(false, true); // we_save() kann die beiden Parameter $resave und $skipHook verarbeiten. durch das $skipHook=true wird eine Endlosschleife verhindert
				}
			}
			break;
	}
	//don't save, with err msg
	//$hookHandler->setErrorString('I don\'t like you! Go away.');
}
?>
