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
