<?php

function color_gradient($color1, $color2, $step) {
	$color1 = str_replace('#', '', $color1);
	$color2 = str_replace('#', '', $color2);
	$c1R = hexdec(substr($color1,0,2));
	$c1G = hexdec(substr($color1,2,2));
	$c1B = hexdec(substr($color1,4,2));
	$c2R = hexdec(substr($color2,0,2));
	$c2G = hexdec(substr($color2,2,2));
	$c2B = hexdec(substr($color2,4,2));
	$R = str_pad(dechex(round(((($step * $c2R) + (100 - $step) * $c1R)/100), 0)), 2, "0", STR_PAD_LEFT);
	$G = str_pad(dechex(round(((($step * $c2G) + (100 - $step) * $c1G)/100), 0)), 2, "0", STR_PAD_LEFT);
	$B = str_pad(dechex(round(((($step * $c2B) + (100 - $step) * $c1B)/100), 0)), 2, "0", STR_PAD_LEFT);
	return '#'.$R.$G.$B; 
}

?>
