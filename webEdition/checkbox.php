<we:ifEditmode>
	<we:input type="checkbox" name="x" />
<we:else />
	<we:ifVar name="x" match="1">
		true
	<we:else />
		false
	</we:ifVar>
</we:ifEditmode>
