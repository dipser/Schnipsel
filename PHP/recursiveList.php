$array = array(
	"x" => array(
		"y" => array(
			"z" => array(
				'a' => array()
			),
			"b"=>array(),
			"c"=>array()
		),
		"d"=>array()
	),
	"e"=>array());

function makeList($array) {
	if (empty($array)) return '';
	$output = '<ul>';
	foreach ($array as $key => $subArray) {
		$output .= '<li>' . $key . makeList($subArray) . '</li>';
	}
	$output .= '</ul>';
	return $output;
}

echo makeList($array);
