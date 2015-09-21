<?php
/**
 * webEdition CMS
 *
 * $Rev: 9029 $
 * $Author: mokraemer $
 * $Date: 2015-01-17 00:44:21 +0100 (Sat, 17 Jan 2015) $
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
we_html_tools::protect();
?>
<style type="text/css">
	.weMarkInputError, input:invalid {
		background-color: #ff8888 ! important;
	}
	.weEditmodeStyle {
		border: 0px ! important;
	}
	.weEditTable{
		border: solid #006DB8 1px;
		background-image:url(<?php echo IMAGE_DIR; ?>backgrounds/aquaBackground.gif);
		color: black;
		font-size: <?php echo ((we_base_browserDetect::isMAC()) ? '11px' : ((we_base_browserDetect::isUNIX()) ? '13px' : '12px')); ?>;
		font-family: <?php echo g_l('css', '[font_family]'); ?>;
	}
	.spacing0{
		border-spacing: 0px;
	}
	.spacing2{
		border-spacing: 2px;
	}

	.padding0 td{
		padding: 0px;
	}
	.padding2 td{
		padding: 2px;
	}
	.border0{
		border-style: none;
	}
</style>
<?php
if(isset($GLOBALS['we_doc'])){
	if($GLOBALS['we_doc']->EditPageNr == we_base_constants::WE_EDITPAGE_CONTENT && $GLOBALS['we_doc']->ContentType == we_base_ContentTypes::TEMPLATE){
		//no wyswyg
	} else {
		echo we_wysiwyg_editor::getHeaderHTML();
	}
}
// Dreamweaver RPC Command ShowPreparedPreview
// disable javascript errors
if(we_base_request::_(we_base_request::STRING, 'cmd') === 'ShowPreparedPreview'){

	echo we_html_element::jsElement('
// overwrite/disable some functions in javascript!!!!
window.open = function(){};
window.onerror = function () {
	return true;
}

function we_rpc_dw_onload() {
	we_cmd = function(){};
	we_submitForm = function(){};
	doUnload = function(){};
}

if (window.addEventListener) {
	window.addEventListener("load", we_rpc_dw_onload);
} else {
	window.attachEvent("onload", we_rpc_dw_onload);
}
');
}

echo we_html_element::jsScript(JS_DIR . 'we_textarea.js');

if(isset($GLOBALS['we_doc'])){
	$useSeeModeJS = array(
		we_base_ContentTypes::WEDOCUMENT => array(we_base_constants::WE_EDITPAGE_CONTENT, we_base_constants::WE_EDITPAGE_PREVIEW),
		we_base_ContentTypes::TEMPLATE => array(we_base_constants::WE_EDITPAGE_PREVIEW, we_base_constants::WE_EDITPAGE_PREVIEW_TEMPLATE),
		"objectFile" => array(we_base_constants::WE_EDITPAGE_CONTENT, we_base_constants::WE_EDITPAGE_PREVIEW)
	);

	if(isset($useSeeModeJS[$GLOBALS['we_doc']->ContentType]) && in_array($GLOBALS['we_doc']->EditPageNr, $useSeeModeJS[$GLOBALS['we_doc']->ContentType])){
		echo we_html_element::jsElement('
function seeMode_dealWithLinks() {
		var _aTags = document.getElementsByTagName("a");

		for (i = 0; i<_aTags.length; i++) {
			var _href = _aTags[i].href;

			if (!(_href.indexOf("javascript:") === 0
							|| _href.indexOf("#") === 0
							|| (_href.indexOf("#") === document.URL.length && _href === (document.URL + _aTags[i].hash))
							|| _href.indexOf("' . we_base_link::TYPE_OBJ_PREFIX . '") === 0
							|| _href.indexOf("' . we_base_link::TYPE_INT_PREFIX . '") === 0
							|| _href.indexOf("' . we_base_link::TYPE_MAIL_PREFIX . '") === 0
							|| _href.indexOf("?") === 0
							|| _href === ""
							)
							) {
				_aTags[i].href = "javascript:seeMode_clickLink(\'" + _aTags[i].href + "\')";

			}
		}
	}

	function seeMode_clickLink(url) {
		top.we_cmd("open_url_in_editor", url);
	}

// add event-Handler, replace links after load
	if (window.addEventListener) {
		window.addEventListener("load", seeMode_dealWithLinks, false);
	} else if (window.attachEvent) {
		window.attachEvent("onload", seeMode_dealWithLinks);
	}
');
	}
}
?>
<script type="text/javascript"><!--
	var _controller = (opener && opener.top.weEditorFrameController) ? opener.top.weEditorFrameController : top.weEditorFrameController;


	var _EditorFrame = _controller.getEditorFrame(parent.name);
	if (!_EditorFrame) {

<?php
echo (($_we_transaction = we_base_request::_(we_base_request::TRANSACTION, "we_transaction", 0)) ?
	"_EditorFrame = _controller.getEditorFrameByTransaction('" . $_we_transaction . "');" :
	"_EditorFrame = _controller.getEditorFrame();");
?>

	}


<?php
if(isset($GLOBALS['we_doc'])){
	if(isset($GLOBALS['we_doc']->ApplyWeDocumentCustomerFiltersToChilds) && $GLOBALS['we_doc']->ApplyWeDocumentCustomerFiltersToChilds && $GLOBALS['we_doc']->ParentID){
		echo "top.we_cmd('copyWeDocumentCustomerFilter', '" . $GLOBALS['we_doc']->ID . "', '" . $GLOBALS['we_doc']->Table . "', '" . $GLOBALS['we_doc']->ParentID . "');";
	}
	?>
		// check if parentId was changed
		var ajaxCallback = {
			success: function (o) {
				if (typeof (o.responseText) !== undefined && o.responseText !== '') {
					var weResponse = false;
					try {
						eval(o.responseText);
						if (weResponse) {
							if (weResponse["data"] === "true") {
								_question = "<?php echo g_l('alert', ($GLOBALS['we_doc']->IsFolder ? '[confirm][applyWeDocumentCustomerFiltersFolder]' : '[confirm][applyWeDocumentCustomerFiltersDocument]')) ?>";
								if (confirm(_question)) {
									top.we_cmd("customer_applyWeDocumentCustomerFilterFromFolder");
								}
							}
						}
					} catch (exc) {
						try {
							//console.log('error in return of GetUpdateDocumentCustomerFilterQuestion' + o.responseText);
						} catch (ex) {

						}

					}
				}
			},
			failure: function (o) {

			}}

		var _oldparentid = <?php echo intval($GLOBALS['we_doc']->ParentID); ?>;
		function updateCustomerFilterIfNeeded() {
			if (_elem = document.we_form["we_<?php echo $GLOBALS['we_doc']->Name; ?>_ParentID"]) {
				_parentid = _elem.value;
				if (_parentid !== _oldparentid) {
					top.YAHOO.util.Connect.asyncRequest('GET', '<?php echo WEBEDITION_DIR; ?>rpc/rpc.php?cmd=GetUpdateDocumentCustomerFilterQuestion&cns=customer&folderId=' + _parentid + '&we_transaction=<?php echo we_base_request::_(we_base_request::TRANSACTION, "we_transaction", '') . '&table=' . $GLOBALS['we_doc']->Table . '&classname=' . $GLOBALS['we_doc']->ClassName; ?>', ajaxCallback);
					_oldparentid = _parentid;
				}
			}
		}

		// check If Filename was changed..
		function pathOfDocumentChanged() {

			var _oldfilepath = '';

			var _filetext = '';
			var _filepath = '';
			var elem = false;

			elem = document.we_form["we_<?php echo $GLOBALS['we_doc']->Name; ?>_Filename"]; // documents
			if (!elem) { // object
				elem = document.we_form["we_<?php echo $GLOBALS['we_doc']->Name; ?>_Text"]
			}

			if (elem) {

				// text
				_filetext = elem.value;
				// Extension if there
				if (document.we_form["we_<?php echo $GLOBALS['we_doc']->Name; ?>_Extension"]) {
					_filetext += document.we_form["we_<?php echo $GLOBALS['we_doc']->Name; ?>_Extension"].value;
				}

				// path
				if (_elem = document.we_form["we_<?php echo $GLOBALS['we_doc']->Name; ?>_ParentPath"]) {
					_filepath = _elem.value;
				}
				if (_filepath != "/") {
					_filepath += "/";
				}

				_filepath += _filetext;
				parent.frames[0].we_setPath(_filepath, _filetext, -1);
	<?php
	if(defined('CUSTOMER_TABLE') && in_array(we_base_constants::WE_EDITPAGE_WEBUSER, $GLOBALS['we_doc']->EditPageNrs) && isset($GLOBALS['we_doc']->documentCustomerFilter)){
		// only use this when customer filters are possible
		?>
					updateCustomerFilterIfNeeded();
		<?php
	}
	?>
			}
		}

<?php } ?>

	function showhideLangLink(allnames, allvalues, deselect) {
		var arr = allvalues.split(",");

		for (var v in arr) {
			w = allnames + '[' + arr[v] + ']';
			e = document.getElementById(w);
			e.style.display = 'block';
		}
		w = allnames + '[' + deselect + ']';
		e = document.getElementById(w);
		e.style.display = 'none';


	}

	function weDelCookie(name, path, domain) {
		if (getCookie(name)) {
			document.cookie = name + "=" +
							((path == null) ? "" : "; path=" + path) +
							((domain == null) ? "" : "; domain=" + domain) +
							"; expires=Thu, 01-Jan-70 00:00:01 GMT";
		}
	}

	function doScrollTo() {
		if (parent.scrollToVal) {
			window.scrollTo(0, parent.scrollToVal);
			parent.scrollToVal = 0;
		}
	}

	function setScrollTo() {
		parent.scrollToVal =<?php echo (we_base_browserDetect::isIE() && we_base_browserDetect::getIEVersion() < 10) ? 'document.body.scrollTop' : 'pageYOffset'; ?>;
	}

	function goTemplate(tid) {
		if (tid > 0) {
			top.weEditorFrameController.openDocument("<?php echo TEMPLATES_TABLE ?>", tid, "<?php echo we_base_ContentTypes::TEMPLATE; ?>");
		}
	}

	function translate(c) {
		f = c.form;
		n = c.name;
		n2 = n.replace(/tmp_/, "we_");
		n = n2.replace(/^(.+)#.+\]$/, "$1]");
		t = f.elements[n];
		check = f.elements[n2].value;

		t.value = (check === "on") ? br2nl(t.value) : nl2br(t.value);

	}
	function nl2br(i) {
		return i.replace(/\r\n/g, "<br/>").replace(/\n/g, "<br/>").replace(/\r/g, "<br/>").replace(/<br\/>/g, "<br/>\n");
	}
	function br2nl(i) {
		return i.replace(/\n\r/g, "").replace(/\r\n/g, "").replace(/\n/g, "").replace(/\r/g, "").replace(/<br ?\/?>/gi, "\n");
	}
	function we_submitForm(target, url) {
		var f = self.document.we_form;

		parent.openedWithWe = true;

		if (target && url) {
			f.target = target;
			f.action = url;
			f.method = "post";
			if (self.weWysiwygSetHiddenText && _EditorFrame.getEditorDidSetHiddenText() == false) {
				weWysiwygSetHiddenText();
			} else if (_EditorFrame.getEditorDidSetHiddenText()) {
				_EditorFrame.setEditorDidSetHiddenText(false);
			}
			if (typeof (self.weEditorSetHiddenText) != "undefined") {
				self.weEditorSetHiddenText();
			}
		}
		f.submit();
	}
	function doUnload() {

		if (jsWindow_count) {
			for (i = 0; i < jsWindow_count; i++) {
				eval("jsWindow" + i + "Object.close()");
			}
		}
	}
	function we_cmd() {
		var args = "";
		var url = "<?php echo WEBEDITION_DIR; ?>we_cmd.php?";
		for (var i = 0; i < arguments.length; i++) {
			url += "we_cmd[" + i + "]=" + encodeURIComponent(arguments[i]);
			if (i < (arguments.length - 1)) {
				url += "&";
			}
		}

		var contentEditor = (top.weEditorFrameController === undefined ? opener.top : top).weEditorFrameController.getVisibleEditorFrame();

		switch (arguments[0]) {
			case "edit_link":
			case "edit_link_at_class":
			case "edit_link_at_object":
				new jsWindow("", "we_linkEdit", -1, -1, 615, 600, true, true, true);
				if (contentEditor.we_submitForm)
					contentEditor.we_submitForm("we_linkEdit", url);
				break;
			case "edit_linklist":
				new jsWindow("", "we_linklistEdit", -1, -1, 615, 600, true, true, true);
				if (contentEditor.we_submitForm)
					contentEditor.we_submitForm("we_linklistEdit", url);
				break;
			case "openColorChooser":
				new jsWindow("", "we_colorChooser", -1, -1, 430, 370, true, true, true);
				if (contentEditor.we_submitForm)
					contentEditor.we_submitForm("we_colorChooser", url);
				break;
			case "openDirselector":
			case "openDocselector":
			case "openImgselector":
				new jsWindow(url, "we_fileselector", -1, -1,<?php echo we_selector_file::WINDOW_DOCSELECTOR_WIDTH . ", " . we_selector_file::WINDOW_DOCSELECTOR_HEIGHT; ?>, true, true, true, true);
				break;
			case "openSelector":
				new jsWindow(url, "we_fileselector", -1, -1, 900, 685, true, true, true, true);
				break;
			case "openCatselector":
				new jsWindow(url, "we_catselector", -1, -1,<?php echo we_selector_file::WINDOW_CATSELECTOR_WIDTH . ", " . we_selector_file::WINDOW_CATSELECTOR_HEIGHT; ?>, true, true, true, true);
				break;
			case "browse_server":
				new jsWindow(url, "browse_server", -1, -1, 840, 400, true, false, true);
				break;
			case "browse_users":
				new jsWindow(url, "browse_users", -1, -1, 500, 300, true, false, true);
				break;
			case "object_editObjectTextArea":
				new jsWindow(url, "edit_object_text", -1, -1, 550, 455, true, false, true);
				break;
			case "editor_uploadFile":
				new jsWindow("", "we_uploadFile", -1, -1, 450, 320, true, true, true);
				if (contentEditor.we_submitForm)
					contentEditor.we_submitForm("we_uploadFile", url);
				break;
			case "open_templateSelect":
				new jsWindow("", "we_templateSelect", -1, -1, 600, 400, true, true, true);
				if (contentEditor.we_submitForm)
					contentEditor.we_submitForm("we_templateSelect", url);
				break;
			case "open_tag_wizzard":
				new jsWindow(url, "we_tag_wizzard", -1, -1, 600, 620, true, true, true);
				break;


<?php if(defined('GLOSSARY_TABLE') && isset($we_doc) && ($we_doc->ContentType == we_base_ContentTypes::WEDOCUMENT || $we_doc->ContentType === "objectFile")){ ?>
				case "glossary_check":
					new jsWindow(url, "glossary_check", -1, -1, 730, 400, true, false, true);
					break;
	<?php
}

if(isset($we_doc) && $we_doc->ContentType == we_base_ContentTypes::IMAGE){
	?>

				case "add_thumbnail":
					new jsWindow(url, "we_add_thumbnail", -1, -1, 400, 410, true, true, true);
					break;
				case "image_resize":
					if (typeof CropTool == 'object' && CropTool.triggered)
						CropTool.drop();
	<?php if($we_doc->gd_support()){ ?>
						new jsWindow(url, "we_image_resize", -1, -1, 260,<?php echo ($we_doc->getGDType() === "jpg") ? 250 : 190; ?>, true, false, true);
		<?php
	} else {
		echo we_message_reporting::getShowMessageCall(sprintf(g_l('weClass', '[type_not_supported_hint]'), g_l('weClass', '[convert_' . $we_doc->getGDType() . ']')), we_message_reporting::WE_MESSAGE_ERROR);
	}
	?>

					break;
				case "image_convertJPEG":
					if (typeof CropTool == 'object' && CropTool.triggered)
						CropTool.drop();
					new jsWindow(url, "we_convert_jpg", -1, -1, 260, 160, true, false, true);
					break;
				case "image_rotate":
					if (typeof CropTool == 'object' && CropTool.triggered) {
						CropTool.drop();
					}
	<?php
	if(function_exists("ImageRotate")){

		if($we_doc->gd_support()){
			?>
							new jsWindow(url, "we_rotate", -1, -1, 300,<?php echo ($we_doc->getGDType() === "jpg") ? 230 : 170; ?>, true, false, true);
			<?php
		} else {
			echo we_message_reporting::getShowMessageCall(sprintf(g_l('weClass', '[type_not_supported_hint]'), g_l('weClass', '[convert_' . $we_doc->getGDType() . ']')), we_message_reporting::WE_MESSAGE_ERROR);
		}
	} else {

		echo we_message_reporting::getShowMessageCall(g_l('weClass', '[rotate_hint]'), we_message_reporting::WE_MESSAGE_ERROR);
	}
	?>
					break;

<?php } ?>
			case "image_crop":
<?php if(defined('WE_EDIT_IMAGE') && $GLOBALS['we_doc']->gd_support()){ ?>
					CropTool.crop();
	<?php
} else if(defined('WE_EDIT_IMAGE')){

	echo we_message_reporting::getShowMessageCall(sprintf(g_l('weClass', '[type_not_supported_hint]'), g_l('weClass', '[convert_' . $GLOBALS['we_doc']->getGDType() . ']')), we_message_reporting::WE_MESSAGE_ERROR);
}
?>
				break;
			case "crop_cancel":
				CropTool.drop();
				break;

			// #SP2015#
			case "image_focus":
				var imgfocus_point_div = document.createElement('div');
				imgfocus_point_div.id = 'imgfocus_point';
				document.getElementById('weImagePanel').appendChild(imgfocus_point_div);

				var div_wrap = document.createElement('div');

				array_html = [
					'<input type="number" name="we_<?php echo $GLOBALS['we_doc']->Name; ?>_input[xfocus]" id="x_focus" value="0" step="0.01" min="-1" max="1" onchange="_EditorFrame.setEditorIsHot(true);" />',
					'<input type="number" name="we_<?php echo $GLOBALS['we_doc']->Name; ?>_input[yfocus]" id="y_focus" value="0" step="0.01" min="-1" max="1" onchange="_EditorFrame.setEditorIsHot(true);" />'
				].join('');

				div_wrap.innerHTML = array_html;
				
				document.getElementById('weImgDiv').appendChild(div_wrap);

				var style_sheet = document.createElement('style');
				style_sheet.innerHTML = '#weImagePanel {position:relative;cursor:hand;} #imgfocus_point {width:0px;height:0px;position:absolute;border:1px solid white;border-radius:50%;box-shadow:0 0 0 1px black;z-index:10;} #imgfocus_point:before {content:"";display:block;position:absolute;left:-16px;top:-16px;width:30px;height:30px;border:1px solid white;border-radius:50%;box-shadow:0 0 0 1px black;}';

				document.getElementById('weImgDiv').appendChild(style_sheet);

				var x_focus = document.getElementById("x_focus");
				var y_focus = document.getElementById("y_focus");
				var imgfocus_wrap = document.getElementById("weImagePanel");
				var imgfocus_point = document.getElementById("imgfocus_point");
				var owidth = imgfocus_wrap.clientWidth, oheight = imgfocus_wrap.clientHeight;
				imgfocus_wrap.addEventListener("click", function(e){
				var twidth = (e.pageX-this.offsetLeft), theight = (e.pageY-this.offsetTop);
					imgfocus_point.style.left = twidth+"px";
					imgfocus_point.style.top = theight+"px";
					x_focus.value = ((twidth/(owidth/2))-1).toFixed(2);
					y_focus.value = ((theight/(oheight/2))-1).toFixed(2);
					x_focus.onchange();
				}, false);
				alert('JSON');
				x_focus.value = (<?=/*$xfocus*/0?>).toFixed(2);
				y_focus.value = (<?=/*$yfocus*/0?>).toFixed(2);
				imgfocus_point.style.left = (((x_focus.value*owidth)+owidth)/2)+"px";
				imgfocus_point.style.top = (((y_focus.value*oheight)+oheight)/2)+"px";

				break;
			// #SP2015#

<?php if(defined('SPELLCHECKER')){ ?>
				case "spellcheck":
					var win = new jsWindow("<?php echo WE_SPELLCHECKER_MODULE_DIR ?>/weSpellchecker.php?editname=" + (arguments[1]), "spellcheckdialog", -1, -1, 500, 450, true, false, true, false);
					break;
<?php } ?>
				// it must be the last command
			case "delete_navi":
				for (var i = 0; i < arguments.length; i++) {
					arguments[i] = encodeURIComponent(arguments[i]);
				}
				if (!confirm("<?php echo g_l('navigation', '[del_question]') ?>"))
					break;
			default:
				for (var i = 0; i < arguments.length; i++) {

					args += 'arguments[' + i + ']' + ((i < (arguments.length - 1)) ? ',' : '');

				}
				eval('parent.we_cmd(' + args + ')');
		}
	}

	function fields_are_valid() {
		var _checkFields = false;
		var _retVal = true;
		var objFieldErrorMsg = "";
<?php
if(isset($GLOBALS['we_doc']) && $GLOBALS['we_doc']->ContentType === "object"){
	echo "
	_checkFields = true;";
}
?>
		if (_checkFields) {

			var theInputs = document.getElementsByTagName("input");

			for (i = 0; i < theInputs.length; i++) {

				if ((theType = theInputs[i].getAttribute("weType")) && (theVal = theInputs[i].value)) {

					switch (theType) {

						case "int":
						case "integer":
							if (!theVal.match(/^-{0,1}\d+$/)) {
<?php
//  don't change the formatting of the fields here
echo we_message_reporting::getShowMessageCall("'" . sprintf(g_l('alert', '[field_contains_incorrect_chars]'), "' + theType + '") . "'", we_message_reporting::WE_MESSAGE_ERROR, true);
?>
								theInputs[i].focus();
								return false;
							} else if (theVal > 2147483647) {
<?php
//  don't change the formatting of the fields here
echo we_message_reporting::getShowMessageCall("'" . g_l('alert', '[field_int_value_to_height]') . "'", we_message_reporting::WE_MESSAGE_ERROR, true);
?>
								theInputs[i].focus();
								return false;
							}
							break;
						case "float":
							if (isNaN(theVal)) {
<?php
//  don't change the formatting of the fields here
echo we_message_reporting::getShowMessageCall("'" . sprintf(g_l('alert', '[field_contains_incorrect_chars]'), "' + theType + '") . "'", we_message_reporting::WE_MESSAGE_ERROR, true);
?>
								theInputs[i].focus();
								return false;
							}
							break;
						case "weObject_input_length":
							if (!theVal.match(/^-{0,1}\d+$/) || theVal < 1 || theVal > 1023) {
<?php
//  don't change the formatting of the fields here
echo we_message_reporting::getShowMessageCall("'" . sprintf(g_l('alert', '[field_input_contains_incorrect_length]')) . "'", we_message_reporting::WE_MESSAGE_ERROR, true);
?>
								theInputs[i].focus();
								return false;
							}
							break;
						case "weObject_int_length":
							if (!theVal.match(/^-{0,1}\d+$/) || theVal < 1 || theVal > 20) {
<?php
//  don't change the formatting of the fields here
echo we_message_reporting::getShowMessageCall("'" . sprintf(g_l('alert', '[field_int_contains_incorrect_length]')) . "'", we_message_reporting::WE_MESSAGE_ERROR, true);
?>
								theInputs[i].focus();
								return false;
							}
							break;
					}
				}
			}

		}
		return true;
	}
//-->
</script>