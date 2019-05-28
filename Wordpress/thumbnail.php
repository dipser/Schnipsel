<?php

// Create thumbnail on the fly and returns basename
function MYPLUGIN_get_thumb($source, $width=null, $height=null, $crop=false) {

    $width = $width ? $width : get_option('thumbnail_size_w');
    $height = $height ? $height : get_option('thumbnail_size_h');
    $crop = $crop;

    $pathinfo = pathinfo($source);

    if ( !in_array(strtolower($pathinfo['extension']), ['jpg','jpeg', 'png']) ) {
        return $pathinfo['basename'];
    }
    
    $thumb_basename = $pathinfo['filename'].'_'.$width.'x'.$height.'.'.$pathinfo['extension'];
    $thumb_target = $pathinfo['dirname'].'/'.$thumb_basename;

    if ( !file_exists($thumb_target) ) {
        $editor = wp_get_image_editor( $source );
        $editor->resize( $width, $height, $crop );
        $new_image_info = $editor->save( $thumb_target );
        return $new_image_info['file'];
    }

    return $thumb_basename;
}
