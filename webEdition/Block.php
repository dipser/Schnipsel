<we:block name="test" start="5">
  <we:ifPosition position="1" type="block" reference="start">
    <we:textarea name="content">Dies ist Inhalt 1</we:textarea>
  </we:ifPosition>

  <we:ifPosition position="2" type="block" reference="start">
    <we:textarea name="content">Dies ist Inhalt 2</we:textarea>
  </we:ifPosition>
</we:block>



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
