<?php
$raw_lines = trim('
name
line1
line2
line3
');
$lines = explode("\n", $raw_lines);

$csv = array_map('str_getcsv', $lines);
array_walk($csv, function(&$a) use ($csv) {
    $a = (object) array_combine($csv[0], $a);
});
array_shift($csv); # remove column header
#echo '<pre>';print_r($csv);echo '</pre>';exit;

$data = $csv;
