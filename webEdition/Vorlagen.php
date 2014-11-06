<?php

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_template.inc.php"); // Für ältere webEdition-Versionen
	
	$newTemplateFilename = 'perphp';
	$templateParentID = 0;
	$templateCode = 'Hallo Welt.';
	
	
	// ID Anhand des Vorlagen-Pfads ermitteln
	$ID = path_to_id(id_to_path($templateParentID).$newTemplateFilename.'.tmpl', TEMPLATES_TABLE);
	$Filename = f('SELECT Filename FROM '.TEMPLATES_TABLE.' WHERE ID='.$ID, "Filename", $GLOBALS['DB_WE']);
	echo $ID.' '.$Filename;
	
	
	// Vorlage erstellen
	if ($ID == 0) {
		$tmpl = new we_template();
		$tmpl->we_new();
		$tmpl->CreationDate = time();
		$tmpl->ID = 0;
		$tmpl->OldPath = "";
		$tmpl->Extension = ".tmpl";
		$tmpl->Filename = $newTemplateFilename;
		$tmpl->Text = $tmpl->Filename . $tmpl->Extension;
		$tmpl->setParentID($templateParentID);
		$tmpl->Path = $tmpl->ParentPath . ($templateParentID ? "/" : "") . $tmpl->Text;
		$tmpl->OldPath = $tmpl->Path;
		$tmpl->setElement('data', $templateCode, "txt");
		$tmpl->we_save();
		$tmpl->we_publish();
		$tmpl->setElement('Charset', 'UTF-8');
		$newTemplateID = $tmpl->ID;
	}
	
	
	// Template bearbeiten
	$tmpl = new we_template();
	$tmpl->initByID( $ID, TEMPLATES_TABLE );
	//$tmpl->ModDate = time(); // Ungetestet
	$tmpl->setElement('data', '<?php echo "Hallo Welt."; ?>', "txt");
	$tmpl->we_save();
	$tmpl->we_publish();
	
?>
