if (defined('USER_TABLE')) { // Test ob die Benutzerverwaltung installiert ist
    $i_id = (int) $GLOBALS['we_doc']->ModifierID;
    $arr_user = getHash('SELECT First, Second FROM '.USER_TABLE.' WHERE ID = '.$i_id, $GLOBALS['DB_WE']);
    echo 'Zuletzt gespeichert von: ', $arr_user['First'], ' ', $arr_user['Second'];
}
