<we:ifEditmode><we:input type="checkbox" name="x" value="1" /></we:ifEditmode>
<we:ifVar name="x" match="1">Ausgabe</we:ifVar>





<we:ifEditmode>
	<we:input type="checkbox" name="x" value="1" />
<we:else />
	<we:ifVar name="x" match="1">
		true
	<we:else />
		false
	</we:ifVar>
</we:ifEditmode>
