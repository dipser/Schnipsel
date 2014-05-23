<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/we_webEditionDocument.inc.php';
$doc = new we_webEditionDocument();
$doc->initByID(9);
$doc->getElement('Headline');
$doc->setElement('Headline', 'Wert');
$doc->we_save();
$doc->we_publish();


?>
