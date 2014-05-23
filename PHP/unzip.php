<?

function unzip($file, $target) {
	$zip = new ZipArchive;
	$res = $zip->open($file);
	if ($res === true) {
		$zip->extractTo($target);
		$zip->close();
		return true;
	}
	return false;
}

?>