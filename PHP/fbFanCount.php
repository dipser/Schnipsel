<?php

/**
 * Ausgabe der Facebook-Fan/Like-Anzahl
 */
function fbFanCount($facebook_name){
	// Example: https://graph.facebook.com/digimantra
	$data = json_decode(file_get_contents("https://graph.facebook.com/".$facebook_name));
	return $data->likes;
}

?>
