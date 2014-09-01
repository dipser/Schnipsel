function makeTextTable($arr) {
	$maxchars = 0;
	foreach ($arr as $k => $v) { $maxchars = (strlen($v[0]) > $maxchars) ? strlen($v[0]) : $maxchars; }
	$ret = array();
	foreach ($arr as $k => $v) {
		$ret[] = str_pad($v[0], $maxchars) . " \t" . $v[1];
	}
	return implode("\r\n", $ret);
}
