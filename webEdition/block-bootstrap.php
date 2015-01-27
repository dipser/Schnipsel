	<we:ifEditmode><br /><div class="row"><div class="col-md-4"></we:ifEditmode>
		<?php $i = 0; ?>
		<we:block name="Details" showselect="false">
				
				<we:ifEditmode>
					<div class="weGroup">
						<div>
							<label class="weText">...</label><br />
							...
						</div><br />
					</div>
					
					<we:ifPosition type="block" position="1" reference="Details" operator="every">
						</div>
						<we:ifNotPosition type="block" position="3" reference="Details" operator="every">
							<we:ifNotPosition type="block" position="last" reference="Details">
								<div class="col-md-4">
							</we:ifNotPosition>
						</we:ifNotPosition>
					</we:ifPosition>
					
					<we:ifPosition type="block" position="3" reference="Details" operator="every">
						<we:ifNotPosition type="block" position="last" reference="Details">
							</div>
						</we:ifNotPosition>
					</we:ifPosition>
					
					<we:ifPosition type="block" position="last" reference="Details"></div></we:ifPosition>
					<we:ifPosition type="block" position="3" reference="Details" operator="every">
						<we:ifNotPosition type="block" position="last" reference="Details">
							<div class="row"><div class="col-md-4">
						</we:ifNotPosition>
					</we:ifPosition>
					
				<we:else />
					<?php if ($i == 0) { ?><div class="row"><?php } ?>
						<div class="col-md-4">
							...
						</div>
				</we:ifEditmode>
				
			<?php $i++; ?>
		</we:block>
	<we:ifEditmode></div><we:else /><?php if ($i>0) { ?></div><?php } ?></we:ifEditmode>
