<?php

/**
 * Get latitude and longitude from an adress
 */
function getLatLong($address){
	if (!is_string($address)) return false;
	$_url = sprintf('http://maps.google.com/maps?output=js&q=%s',rawurlencode($address));
	$_result = false;
	if($_result = file_get_contents($_url)) {
		if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false) return false;
		preg_match('!center:\s*{lat:\s*(-?\d+\.\d+),lng:\s*(-?\d+\.\d+)}!U', $_result, $_match);
		$_coords['lat'] = $_match[1];
		$_coords['long'] = $_match[2];
	}
	return $_coords;
}

?>
