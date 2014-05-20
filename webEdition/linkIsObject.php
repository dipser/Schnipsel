<?
function linkIsObject($name) {
	return (we_tag('link', array('name'=>$name, 'only'=>'type')) == 'obj');
}
function ifObjectTrigger($name, $triggerid) {
	if ( linkIsObject($name) ) {
	  $objid = we_tag('link', array('name'=>$name, 'only'=>'obj_id'));
	  $tlink = we_tag('url', array('type'=>'object', 'id'=>$objid, 'triggerid'=>$triggerid));
	} else {
	  $tlink = we_tag('link', array('name'=>$name, 'only'=>'href'));
	}
}
?>