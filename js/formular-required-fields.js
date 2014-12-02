// Formulare (Entferne required vor dem ersten abschicken, da :required automatisch das Feld auf :invalid setzt)
$('main form').each(function(i,v){
  var me = this;
  $(me).on('submit', function(e){
  	if ( !$(me).hasClass('submittedOnce') ) {
  		e.preventDefault();
  		$(me).addClass('submittedOnce');
  		$('.required', me).prop('required', true);
  		if (!$(':invalid', me).length) { $(me).submit(); }
  	}
  });
  // replaceRequiredFields
  $(':required', this).each(function(i2,v2){ $(v2).addClass('required').removeAttr('required'); });
});
