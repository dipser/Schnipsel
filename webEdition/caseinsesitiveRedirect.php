<?php
  // Redirect if 404 and caseinsensitive document exists
	function caseinsesitiveRedirect() {
		// Checks if we have an error 404...
		if ( isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == 404 ) {
			// Get existing file...
			$REQUEST_URI = $_SERVER['REQUEST_URI']; // => /origdir/subdir/file.php?x=y
			$requestfilepath = strtok($REQUEST_URI, '?');
			if ( substr($requestfilepath, -1) == '/' ) { $requestfilepath = substr($requestfilepath, 0, -1); }
			$realfileid = path_to_id($requestfilepath);
			if ( $realfileid>0 ) {
				$realfilepath = id_to_path($realfileid);
				$query_and_hash = strtok('?');
				$realfilepath .= strlen($query_and_hash)>0 ? '?'.$query_and_hash : '';
				// Redirect...
				header('Location: '.$realfilepath, true, 302);
				exit;
			}
		}
		return false;
	}
?>
