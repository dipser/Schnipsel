<?php
/**
 * Sammlung typischer Eingabefehler bei Emails:
 *
 * -de
 * :de
 * .de.
 * " "de
 * @.
 * .@
 * @" "
 * " "@
 * Großschreibung: . wird zu :
 * @-online statt @t-online.de
 * @gmxcom statt @gmx.com
 */

$csv = array();
$csvNew = array();

for ($i = 0; $i < count($csv); $i++) {
  $csvLine = explode(',', $csv[$i]);
  $mail = $csvLine[0];
  $rest = array_slice($input, 1);
  
  // ...Autokorrektur...
  
  $csvNew = array_push($mail, $rest);
}
