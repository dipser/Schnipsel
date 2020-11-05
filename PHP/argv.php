<?php

$argvs = array (
0 => 'path/to/worker.php',
1 => '--this=1',
2 => '--that=1=1',
);

if ( !empty($argv) ) {
    foreach ($argv as $i => $a) {
        if ($i === 0) continue;
        preg_match("/\-\-(.*?)=(.*)/", $a, $r);
        $_GET[ $r[1] ] = $r[2];
    }
}

var_export($_GET);
