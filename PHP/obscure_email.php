<?php
	function obscure_email($e) {
		$output = '';
		for ($i = 0; $i < strlen($e); $i++) {
			$output .= '&#'.ord($e[$i]).';';
		}
		return $output;
	}
?>
