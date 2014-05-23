<?
// Loads and saves a file to server
function download($source, $target) {
	$docroot = $_SERVER['DOCUMENT_ROOT'];
	return file_put_contents($docroot.'/'.$target, file_get_contents($source));
}
?>