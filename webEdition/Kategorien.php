<?php
$GLOBALS['DB_WE']->query('SELECT Path FROM '.CATEGORY_TABLE);
while($GLOBALS['DB_WE']->next_record())
{
    $MyCategories = (string) $GLOBALS['we_doc']->getElement('MyCategories');
	$Category = (string) $GLOBALS['DB_WE']->f('Category');
    $Path = (string) $GLOBALS['DB_WE']->f('Path');
    echo '<option'.(($MyCategories == $Path) ? ' selected="selected"' : '').'>'.$Path.'</option>';
}
?>

<?php echo id_to_path(123, 'tblCategorys'); ?>


<div>
	<we:listview type="category" name="WasAuchImmer" parentid="1">
		<we:repeat>
			<we:field name="ID" to="global" /><?php $pID = $GLOBALS['ID']; ?>
			<we:field name="Category" to="global" /><?php $pCategory = $GLOBALS['Category']; ?>
			<we:field name="Title" to="global" /><?php $pTitle = $GLOBALS['Title']; ?>
			<div class="group" style="margin-bottom:10px;">
				<b><?=( strlen($pTitle)>0 ? $pTitle : $pCategory )?></b><br />
				<we:listview type="category" parentid="$pID">
					<we:repeat>
						<we:field name="ID" to="global" /><?php $ID = $GLOBALS['ID']; ?>
						<we:field name="Category" to="global" /><?php $Category = $GLOBALS['Category']; ?>
						<we:field name="Title" to="global" /><?php $Title = $GLOBALS['Title']; ?>
						<div>
							<we:input type="checkbox" name="x_$ID" id="x_$ID" title="Kategorie-ID: $ID" />
							<label for="x_<?=$ID?>" style="margin-left:5px;"><?=( strlen($Title)>0 ? $Title : $Category )?></label>
							<we:ifNotEmpty match="x_$ID">
								...
							</we:ifNotEmpty>
						</div>
					</we:repeat>
				</we:listview>
			</div>
		</we:repeat>
	</we:listview>
</div>
