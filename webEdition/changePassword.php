<?php
	
	function weChangePassword($username, $newpass) {
		$userdata = getHash('SELECT ID, UseSalt, passwd, username, LoginDenied FROM ' . USER_TABLE . ' WHERE IsFolder=0 AND username="' . $GLOBALS['DB_WE']->escape($username) . '"', $DB_WE);
		$pwd = we_user::makeSaltedPassword($userdata['UseSalt'], $userdata['username'], $newpass);
		$GLOBALS['DB_WE']->query('UPDATE ' . USER_TABLE . ' SET passwd="' . $GLOBALS['DB_WE']->escape($pwd) . '", UseSalt=' . $userdata['UseSalt'] . ' WHERE ID=' . $userdata['ID']);
	}
	//weChangePassword('MeinBenutzername', 'MeinPasswort');
	
?>