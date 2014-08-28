function stack2nested($stack) {
	$arr = array();
	$firstelem = array_shift($stack);
	$arr[$firstelem] = count($stack) > 0 ? stack2nested($stack) : array();
	return $arr;
}
