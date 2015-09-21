<?php
/**
 * webEdition CMS
 *
 * $Rev: 8639 $
 * $Author: mokraemer $
 * $Date: 2014-11-26 12:24:47 +0100 (Wed, 26 Nov 2014) $
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package none
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */
define("WE_EDIT_IMAGE", true);


echo we_html_tools::getHtmlTop();

if(substr(we_base_request::_(we_base_request::STRING, 'we_cmd', '', 0), 0, 15) === "doImage_convert"){
	echo we_html_element::jsElement('parent.frames[0].we_setPath("' . $we_doc->Path . '","' . $we_doc->Text . '", "' . $we_doc->ID . '");');
}

echo we_html_element::jsScript(JS_DIR . 'windows.js');
require_once(WE_INCLUDES_PATH . 'we_editors/we_editor_script.inc.php');

echo STYLESHEET;
?>
</head>

<body class="weEditorBody" style="padding:20px;">

	<form name="we_form" method="post" onsubmit="return false;">
		<?php
		echo we_class::hiddenTrans();
		$_headline = g_l('weClass', '[image]');

		$_gdtype = $we_doc->getGDType();


		echo '<table cellpadding="0" cellspacing="0" border="0">
' . ($we_doc->EditPageNr == 15 ?
			'<tr><td><select name="editmenue" size="1" onchange="var cmnd = this.options[this.selectedIndex].value; if(cmnd){if(cmnd==\'doImage_convertPNG\' || cmnd==\'doImage_convertGIF\'){_EditorFrame.setEditorIsHot(true);};we_cmd(cmnd,\'' . $we_transaction . '\');}this.selectedIndex=0"' . (($we_doc->getElement("data") && we_base_imageEdit::is_imagetype_read_supported($_gdtype) && we_base_imageEdit::gd_version() > 0) ? "" : ' disabled="disabled"') . '>
<option value="">' . g_l('weClass', '[edit]') . '</option>
<!-- Begin: #SP2015# -->
<option value="image_focus">Bildfokus</option>
<!-- End: #SP2015# -->
<option value="image_resize">' . g_l('weClass', '[resize]') . '&hellip;</option>
<option value="image_rotate">' . g_l('weClass', '[rotate]') . '&hellip;</option>
<option value="image_crop">' . g_l('weClass', '[crop]') . '&hellip;</option>
<option value="" disabled="disabled" style="color:grey">' . g_l('weClass', '[convert]') . '</option>' .
			((in_array("jpg", we_base_imageEdit::supported_image_types())) ? '<option value="image_convertJPEG">&nbsp;&nbsp;' . g_l('weClass', '[convert_jpg]') . '...</option>' : '') .
			(($_gdtype != "gif" && in_array("gif", we_base_imageEdit::supported_image_types())) ? '<option value="doImage_convertGIF">&nbsp;&nbsp;' . g_l('weClass', '[convert_gif]') . '</option>' : '') .
			(($_gdtype != "png" && in_array("png", we_base_imageEdit::supported_image_types())) ? '<option value="doImage_convertPNG">&nbsp;&nbsp;' . g_l('weClass', '[convert_png]') . '</option>' : '') .
			'</select></td></tr>
<tr><td>' . we_html_tools::getPixel(2, 10) . '</td></tr>
<tr><td>' . we_html_tools::getPixel(2, 10) . '</td></tr>' :
			''
		) . '<tr><td>' . $we_doc->getHtml(true) . '</td></tr>'
		. '</table>';
		?>
		<input type="hidden" name="we_complete_request" value="1"/>
	</form>
</body>
</html>