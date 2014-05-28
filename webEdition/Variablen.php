<?php

// Textarea WYSIWYG (tinyMCE) Editor
$taCommands = (DEV?'forecolor,':'').'bold,italic,underline,formatblock,removeformat,redo,undo,pastetext,link,insertunorderedlist,insertimage,hr,fullscreen,editsource'; 
$tinyAttr = "theme_advanced_blockformats:'p,h2,h3,h4'";



// Anzahl Blöcke
$anzahl = count(unserialize($GLOBALS['we_doc']->getElement('meinBlock')));


$doclang = $GLOBALS['we_doc']->Language;


// Anzahl innerhalb eines listviews
//<we:listviewRows /> 
<? echo $lv->anz_all; ?>

?>
