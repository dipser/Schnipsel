<?php

// Testprogramm


$url = "http://api.openweathermap.org/data/2.5/forecast/daily?id=2950159&mode=json&units=metric&cnt=1&lang=de";

echo '<h1>Testprogramm zum lesen externer Dateien</h1>';
echo '&raquo; <a href="'.$url.'">Externe URL</a><br />';
echo '&raquo; max_execution_time: '.(ini_get('max_execution_time')).'<br />';
echo '&raquo; safe_mode: '.((int)ini_get('safe_mode')).'<br />';
echo '&raquo; allow_url_fopen: '.((int)ini_get('allow_url_fopen')).'<br /><br /><hr /><br />';



set_time_limit(5);


echo '<h2><a href="?type=1">1. file_get_contents</a></h2>';
if ($_GET['type']==1) {
	$context = stream_context_create(array(
		'http' => array(
			'method' => 'GET',
			'timeout' => 5
		)
	));
	$content = file_get_contents($url);
	echo '<pre>'.$content.'</pre>';
}



echo '<h2><a href="?type=2">2. cURL</a></h2>';
if ($_GET['type']==2) {
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, "http://www.google.de/");
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec ($ch);
	curl_close ($ch);
	echo '<pre>'.$content.'</pre>';
}


echo '<h2><a href="?type=3">3. fopen</a></h2>';
if ($_GET['type']==3) {
	$filename = $url;
	$handle = fopen ($filename, "r");
	while(!feof($handle)) {
		$contents .= fread ($handle, 1024);
	}
	fclose ($handle);
	echo '<pre>'.$contents.'</pre>';
}


?>
