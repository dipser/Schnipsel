<?php
function base64_encode_datauri($filename, $filepath)
{
    $type = pathinfo($filename, PATHINFO_EXTENSION);
    $mediatype = '';
    if ($type == 'svg') {$mediatype = 'image/svg+xml';} 
    elseif ($type == 'png') {$mediatype = 'image/png';} 
    elseif ($type == 'jpg' || $type = 'jpeg') {$mediatype = 'image/jpeg';} 
    elseif ($type == 'gif') {$mediatype = 'image/gif';}
    if ($filepath) {
        return 'data:' . $mediatype . ';base64,' . base64_encode(file_get_contents($filepath));
    }
}
