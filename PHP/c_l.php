<?php
// Logs an array like $we_doc to firebug etc.
function c_l() {
    echo '<script>var console=console||{"log":function(){}};console.log('.json_encode(func_get_args()).');</script>';
}
c_l('Get', $_GET, 'Cookie', $_COOKIE, 'Session', $_SESSION);
?>
