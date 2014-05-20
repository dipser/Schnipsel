<?
// Logs an array like $we_doc to firebug etc.
function c_l($r) {
    echo '<script>var console=console||{"log":function(){}};console.log('.json_encode($r).');</script>';
}
?>