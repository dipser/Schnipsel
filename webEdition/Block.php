<we:block name="test" start="5">
  <we:ifPosition position="1" type="block" reference="start">
    <we:textarea name="content">Dies ist Inhalt 1</we:textarea>
  </we:ifPosition>

  <we:ifPosition position="2" type="block" reference="start">
    <we:textarea name="content">Dies ist Inhalt 2</we:textarea>
  </we:ifPosition>
</we:block>




<we:block name="meinBlock">
</we:block>
<?php
$anzahl = count(unserialize($GLOBALS['we_doc']->getElement('meinBlock')));
?>



    $em=$GLOBALS['we_editmode'];
    $GLOBALS['we_editmode']=false;
    $block=we_tag('block',array("name"=>"test"));
    while(we_condition_tag_block($block)){
      $innerBlock=we_tag('block',array("name"=>"inner"));
      while(we_condition_tag_block($innerBlock)){
        $inhalt=we_tag('input',array("type"=>"text"));
      }
    }
    $GLOBALS['we_editmode']=$em;


so bist du auch weitestgehend auf der sicheren Seite bei Updates.
Du solltest noch $block bzw. $innerBlock auf !=false prüfen.








// Spalten für den Editmode

<style>table {border:1px solid red;} td {border:1px solid orange;}</style>

<table><tr><td>
<we:block name="test" showselect="false">
	
	<div><we:input type="text" name="x" /></div>
	
	<we:ifPosition type="block" position="1" reference="test" operator="every">
		</td>
		<we:ifNotPosition type="block" position="3" reference="test" operator="every">
			<we:ifNotPosition type="block" position="last" reference="test">
				<td>
			</we:ifNotPosition>
		</we:ifNotPosition>
	</we:ifPosition>
	
	<we:ifPosition type="block" position="3" reference="test" operator="every">
		<we:ifNotPosition type="block" position="last" reference="test">
			</tr>
		</we:ifNotPosition>
	</we:ifPosition>
	
	<we:ifPosition type="block" position="last" reference="test"></tr></we:ifPosition>
	<we:ifPosition type="block" position="3" reference="test" operator="every">
		<we:ifNotPosition type="block" position="last" reference="test">
			<tr><td>
		</we:ifNotPosition>
	</we:ifPosition>
</we:block>
</table>
