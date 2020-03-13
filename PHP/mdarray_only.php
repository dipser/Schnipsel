<?php

function mdarray_only($array, $only_columns = []) {
    $array = (array) $array;
    array_walk($array, function(&$row, $key) use ($only_columns) { // All rows
        $cells = (array) $row;
        $row = array_filter($cells, function($v, $k) use ($only_columns) { return in_array($k, $only_columns); }, ARRAY_FILTER_USE_BOTH);
    });
    return $array;
}
