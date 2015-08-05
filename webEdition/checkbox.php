<we:ifEditmode>
	<we:input type="checkbox" name="x" /><?php /* value="1" für true am anfang */ ?>
<we:else />
	<we:ifVar name="x" match="1">
		true
	<we:else />
		false
	</we:ifVar>
</we:ifEditmode>
