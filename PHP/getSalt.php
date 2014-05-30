<?php

/**
 * Salt
 */
function getSalt($dynamic = true)
    $salt_static = '‹1rmin5ul+#ß‡›'; // Never to be changed.
    $salt_dynamic = uniqid(mt_rand(), true); // Generated salt for saving into Database.  // => 33 Zeichen
    return $dynamic ? $salt_dynamic : $salt_static;
}

?>
