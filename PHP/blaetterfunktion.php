<?php

$page = (int) $_GET[‘page’]; // Actual page number
$items = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);

$minslice = 2; // Number of min slice
$maxslice = 5; // Number of max slice
$limit = 2;    // Number of items on one page


$total_pages = ceil( count($items) / $limit );
$pages = range(1, $total_pages); // Array of all pages

// Page: [1] [2]
$first = array_slice($pages, 0, (($page<(2*$minslice))?$maxslice:$minslice), true);

// Page: [x-1] [x] [x+1]
$middle = array();
if($page>$minslice && $page<=$total_pages-$minslice)
    $middle = array_slice($pages, $page-$minslice, $maxslice-$minslice, true);

// Page: [n-1] [n]
$l = (($page>$total_pages-(2*$minslice))?$maxslice:$minslice);
$last = array_slice($pages, -1*$l, $l, true);

$merged = $first + $middle + $last; // Merging array with preserved keys
ksort($merged); // Sort keys



// Creating an array of pagination or just echo it.
$last_key = -1;
$pagination = array();
foreach ($merged as $key => $val) {
    // Page/Text, Query
    if($key-1!==$last_key) $pagination[] = array(‘…’, NULL);
    $pagination[] = array($val, ‘?page=’.$val);
    
    $last_key = $key;
}

?>
