<?php
// http://qa.webedition.org/tracker/view.php?id=9483
$img = new we_imageDocument();
$img->initByID(1);
echo $meta_title = $img->getElement('Title');
echo $meta_description = $img->getElement('Description');
?>

