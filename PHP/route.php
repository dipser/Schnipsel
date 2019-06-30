<?php

define('ABSPATH', dirname(__FILE__));

// ...

// Route
$request_path = str_replace(ABSPATH, '', $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
$route = parse_url($request_path, PHP_URL_PATH);
