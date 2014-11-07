<?php

/**
 * webEdition Funktionen:
 *
 * - p_r($var)
 * - error_log2($variable) // Schreibt beliebige Variablen, Arrays und Objekte, auch verschachtelt, in die PHP-Error-Log-Datei. 
 * - removePHP( string $val )
 * - removeHTML($val)
 * - we_tag( string $name , array $attribs [, string $content] )
 * - $GLOBALS['we_doc']->setElement('Headline', 'Das ist ein Beispieltext.');
 *   <we:input type="text" name="Headline"/>
 *   $GLOBALS['we_doc']->getElement('Headline')
 * - id_to_path($ID)
 *   <we:url id="42" />
 * - path_to_id($str)
 * - makeArrayFromCSV($csv)
 * - makeCSVFromArray($arr, $prePostKomma=false, $sep=",")
 * - $db = new DB_WE();
 *   $db->escape($unsafe_variable); // Sanitizing data
 *   $db->query("SELECT Path FROM " . FILE_TABLE . " WHERE IsFolder=0 ORDER By ID");
 *   print "Anzahl Zeilen: " . $db->num_rows() . "<br>";
 *   while ($db->next_record()) {
 *     print $db->f("Path") . "<br>";
 *   }
 * 
 */
 
?>
