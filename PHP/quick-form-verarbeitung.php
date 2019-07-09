<?php

$fields = [
    // kategorie1
    ['cat'=>'kategorie1', 'name'=>'feld1', 'label'=>'Feld 1', 'filter'=>FILTER_SANITIZE_STRING],
    ['cat'=>'kategorie1', 'name'=>'feld2', 'label'=>'Feld 2', 'filter'=>FILTER_SANITIZE_STRING],
    // kategorie2
    ['cat'=>'kategorie2', 'name'=>'feld3', 'label'=>'Feld 3', 'required'=>true, 'filter'=>FILTER_SANITIZE_STRING],
    ['cat'=>'kategorie2', 'name'=>'feld4', 'label'=>'Feld 4', 'required'=>true, 'filter'=>FILTER_SANITIZE_STRING]
];


// Check if field is required
function formFieldIsRequired($q) {
    global $fields;
    foreach ($fields as $item) {
        if ($item['name'] == $q && isset($item['required']) && $item['required']) {
            return true;
        }
    }
    return false;
}

// Get field by category
function formFields($q = false) { // "q" can be an array
    global $fields;
    $f = [];
    foreach ($fields as $item) {
        $cats = !empty($item['cat']) ? (is_array($item['cat']) ? $item['cat'] : [$item['cat']]) : [];
        if ( $q === false ) {
            $f[] = $item;
        } else {
            if ( !is_array($q) ) $q = [$q];
            foreach ( $q as $q_item ) {
                if ( in_array($q_item, $cats) ) {
                    $f[] = $item;
                }
            }
        }
    }
    return $f;
}
//echo '<pre>';print_r(formFields(['kategorie1','kategorie2']));exit;

if ($_POST['submit']) {

    $errors = [];

    // Sanitize, required and errors
    foreach ($fields as $field) {
        $name = $field['name'];
        // Sanitize-Filter
        if ( isset($field['filter']) && $field['filter'] ) {
            filter_input(INPUT_POST, $name, $field['filter']);
        }
        // Required
        if ( isset($field['required']) && $field['required'] ) {
            if ( empty($_POST[$name]) ) 
                $errors[$name] = true;
        }
    }

    //echo '<pre>'.print_r($errors);exit;
    if ( !$errors ) {
    
      // ...
    
    }
}
