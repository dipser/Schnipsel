<?php
// Pfad: /webEdition/we/include/we_hook/custom_hooks/weCustomHook_save.inc.php
// http://forum.webedition.org/viewtopic.php?f=120&t=40066
function weCustomHook_save($param){
	$hookHandler = $param['hookHandler'];
	$resave = $param['resave'];
	$obj = $param[0];
	switch(get_class($obj)){
		// beim Speichern von Less Dateien im Ordner /system/css/include auch die masterdateien styles.less / lightbox.less etc. speichern
		case 'we_textDocument':
			// ich pruefe zusaetzlich noch das Verzeichnis der Dateien ab
			if ((in_array($obj->ParentID, array(21,22)) && ($obj->Extension == '.less') && ($obj->parseFile == false)) {
				$aMasterIDs = array(10);
				foreach($aMasterIDs as $iID) {
					$masterfile = new we_textDocument();
					$masterfile->initByID($iID);
					$masterfile->we_save(false, true);// we_save() kann die beiden Parameter $resave und $skipHook verarbeiten. durch das $skipHook=true wird eine Endlosschleife verhindert
				}
			}
			break;
	}
	//don't save, with err msg
	//$hookHandler->setErrorString('I don\'t like you! Go away.');
}
?>
