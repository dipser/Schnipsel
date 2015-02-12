<?php
...
if ($param[0]->Extension=='.less' && $param[0]->parseFile==0) {
   $mainID = 11;
   $docMain = new we_webEditionDocument();
   $docMain->initByID($mainID);
   $docMain->we_save(false, true); // we_save() kann die beiden Parameter $resave und $skipHook verarbeiten. durch das $skipHook=true wird eine Endlosschleife verhindert
   $docMain->we_publish(); // << Ist das überhaupt nötig?
}
...
?>

<?php
  // ThomasGoebe - http://forum.webedition.org/viewtopic.php?f=120&t=40066
  function weCustomHook_save($param) {
    $hookHandler=$param['hookHandler'];
    $resave=$param['resave'];
    $obj=$param[0];
    
    switch(get_class($obj)) {
      // beim Speichern von Less Dateien im Ordner /system/css/include auch die masterdateien styles.less / lightbox.less etc. speichern
      case 'we_textDocument':
        // ich pruefe zusaetzlich noch das Verzeichnis der Dateien ab
        if (($obj->ParentID == 161) && ($obj->Extension == '.less') && ($obj->parseFile == false)) {
          $aMasterIDs = array(4,135);
          foreach($aMasterIDs as $iID) {
            $masterfile = new we_textDocument();
            $masterfile->initByID($iID);
            $masterfile->we_save(false, true);
          }
        }
        break;
    }
  }
?>
