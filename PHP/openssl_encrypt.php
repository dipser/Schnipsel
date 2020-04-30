<?php

// hex2bin() muss nicht benutzt werden

$text = ('Hello');
$key = hex2bin('E0FAC2DD2C00FFE30F27A6D14568CB4F12EB84676A3A2BFB172A444C3BBB831F');
$iv = hex2bin('5A79774BB4B326EED949E6871FC27697');
$result = openssl_encrypt($text, 'AES-256-CBC', $key, 0, $iv);
var_dump($result);

echo '<hr>';

$ciphertext = ($result);
$key = hex2bin('E0FAC2DD2C00FFE30F27A6D14568CB4F12EB84676A3A2BFB172A444C3BBB831F');
$iv = hex2bin('5A79774BB4B326EED949E6871FC27697');
$result = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
var_dump($result);

echo '<hr>';


$ciphertext = 'sp0z18QezUO8tSy7tgjOEw==';
$key = hex2bin('E0FAC2DD2C00FFE30F27A6D14568CB4F12EB84676A3A2BFB172A444C3BBB831F');
$iv = hex2bin('5A79774BB4B326EED949E6871FC27697');
$result = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
var_dump($result);

echo '<hr>';
