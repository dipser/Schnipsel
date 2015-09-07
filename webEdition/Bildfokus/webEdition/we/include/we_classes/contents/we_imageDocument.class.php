<?php
/**
 * webEdition CMS
 *
 * $Rev: 10367 $
 * $Author: mokraemer $
 * $Date: 2015-08-27 21:41:14 +0200 (Thu, 27 Aug 2015) $
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

/**
 * class for handling image documents
 */
class we_imageDocument extends we_binaryDocument{
	const ALT_FIELD = '_img_custom_alt';
	const TITLE_FIELD = '_img_custom_title';
	const THUMB_FIELD = '_img_custom_thumb';

	private static $imgCnt = 0;

	/**
	 * Comma separated value of IDs from THUMBNAILS_TABLE  This value is not stored in DB!!
	 * @var string
	 */
	var $Thumbs = -1;

	/**
	 * Constructor of we_imageDocument
	 *
	 * @return we_imageDocument
	 */
	function __construct(){
		parent::__construct();

		array_push($this->persistent_slots, 'Thumbs', 'IsProtected');
		$this->ContentType = we_base_ContentTypes::IMAGE;
		if(isWE()){
			array_push($this->EditPageNrs, we_base_constants::WE_EDITPAGE_IMAGEEDIT, we_base_constants::WE_EDITPAGE_THUMBNAILS);
		}
		self::$imgCnt++;
	}

	/**
	 * saves the data of the document
	 *
	 * @return boolean
	 * @param boolean $resave
	 */
	public function we_save($resave = false, $skipHook = false){
		// get original width and height of the image
		$arr = $this->getOrigSize(true, true);
		$this->setElement('origwidth', isset($arr[0]) ? $arr[0] : 0, 'attrib');
		$this->setElement('origheight', isset($arr[1]) ? $arr[1] : 0, 'attrib');
		$docChanged = $this->DocChanged; // will be reseted in parent::we_save()
		if(parent::we_save($resave, $skipHook)){
			$this->unregisterMediaLinks();
			$ret = $this->registerMediaLinks();
			$thumbs = $this->getThumbs();
			if($docChanged){
				we_thumbnail::deleteByImageID($this->ID);
			}
			if($thumbs){
				foreach($thumbs as $thumbID){
					$thumbObj = new we_thumbnail();
					$thumbObj->initByThumbID($thumbID, $this->ID, $this->Filename, $this->Path, $this->Extension, $this->getElement('origwidth'), $this->getElement('origheight'), $this->getDocument());
					if(($docChanged || !$thumbObj->exists()) && ($thumbObj->createThumb() == we_thumbnail::BUILDERROR)){
						t_e('Error creating thumbnail for file', $this->Filename . $this->Extension);
					}
				}
			}

			return $ret;
		}

		return false;
	}

	function registerMediaLinks(){
		if(($id = $this->getElement('LinkID', 'bdid'))){
			$this->MediaLinks[] = $id;
		}
		if(($id = $this->getElement('RollOverID', 'bdid'))){
			$this->MediaLinks[] = $id;
		}

		return parent::registerMediaLinks(false, true);
	}

	/**
	 * Calculates the original image size of the image.
	 * Returns an array like the PHP function getimagesize().
	 * If the array is empty the image is not uploaded or an error occured
	 *
	 * @param boolean $calculateNew
	 * @return array
	 */
	function getOrigSize($calculateNew = false, $useOldPath = false){
		$arr = array(0, 0, 0, '');
		if(!$this->DocChanged && $this->ID){
			if($this->getElement('origwidth') && $this->getElement('origheight') && ($calculateNew == false)){
				return array($this->getElement('origwidth'), $this->getElement('origheight'), 0, '');
			}
			// we have to calculate the path, because maybe the document was renamed
			//$path = $this->getParentPath() . '/' . $this->Filename . $this->Extension;
			return we_thumbnail::getimagesize(WEBEDITION_PATH . '../' . (($useOldPath && $this->OldPath) ? $this->OldPath : $this->Path));
		} else if(($tmp = $this->getElement('data'))){
			$arr = we_thumbnail::getimagesize($tmp);
		}
		return $arr;
	}

	/**
	 * Returns an array with the Thumbnail IDs for the image.
	 *
	 * @return array
	 */
	function getThumbs(){
		$thumbs = array();
		if($this->Thumbs == -1){
			$this->DB_WE->query('SELECT * FROM ' . THUMBNAILS_TABLE);
			$thumbObj = new we_thumbnail();

			while($this->DB_WE->next_record()){
				$thumbObj->init($this->DB_WE->f('ID'), $this->DB_WE->f('Width'), $this->DB_WE->f('Height'), $this->DB_WE->f('Ratio'), $this->DB_WE->f('Maxsize'), $this->DB_WE->f('Interlace'), false, $this->DB_WE->f('Format'), $this->DB_WE->f('Name'), $this->ID, $this->Filename, $this->Path, $this->Extension, $this->getElement('origwidth'), $this->getElement('origheight'), $this->DB_WE->f('Quality'));

				if($thumbObj->exists() && $thumbObj->getOutputPath() != $this->Path){
					$thumbs[] = $this->DB_WE->f('ID');
				}
			}

			$this->Thumbs = implode(',', $thumbs);
		} else {
			$thumbs = implode(',', $this->Thumbs);
		}
		return $thumbs;
	}

	/**
	 * returns the path for the template to be included
	 *
	 * @return string
	 */
	function editor(){
		switch($this->EditPageNr){
			case we_base_constants::WE_EDITPAGE_THUMBNAILS:
				return 'we_editors/we_editor_thumbnails.inc.php';

			default:
				return parent::editor();
		}
	}

	/**
	 * adds thumbnails to the image document
	 *
	 * @return void
	 * @param string $thumbsToAdd
	 */
	function add_thumbnails($thumbsToAdd){
		$thumbsArray = ($this->Thumbs == -1) ? array() : makeArrayFromCSV($this->Thumbs);

		foreach($thumbsToAdd as $t){
			if(!in_array($t, $thumbsArray)){
				$thumbsArray[] = $t;
			}
		}

		$this->Thumbs = implode(',', $thumbsArray);
		$this->DocChanged = true;
	}

	/**
	 * deletes a thumbnail from the image document
	 *
	 * @return void
	 * @param int $thumbnailID
	 */
	function del_thumbnails($thumbnailID){
		$thumbsArray = ($this->Thumbs == -1) ? array() : makeArrayFromCSV($this->Thumbs);
		$newArray = array();

		foreach($thumbsArray as $t){
			if($t != $thumbnailID){
				$newArray[] = $t;
			}
		}

		$this->Thumbs = implode(',', $newArray);
		$this->DocChanged = true;
	}

	/**
	 * sets extra attributes for the image
	 *
	 * @return void
	 * @param array $attribs
	 */
	function initByAttribs($attribs){
		foreach($attribs as $a => $b){
			if(strtolower($a) != 'id' && $b != ''){
				$this->setElement($a, $b, 'attrib');
			}
		}
		$this->checkDisableEditpages();
	}

	public function initByID($ID, $Table = '', $from = we_class::LOAD_MAID_DB){
		parent::initByID($ID, $Table, $from);
		if(!empty($GLOBALS['we_editmode'])){
			$this->checkDisableEditpages();
		}
	}

	public function isSvg(){
		switch($this->Extension){
			case '.svg':
			case '.svgz':
				return true;
		}
		return false;
	}

	private function checkDisableEditpages(){
		if($this->isSvg()){
			if(($pos = array_search(we_base_constants::WE_EDITPAGE_IMAGEEDIT, $this->EditPageNrs)) !== false){
				unset($this->EditPageNrs[$pos]);
			}
			if(($pos = array_search(we_base_constants::WE_EDITPAGE_THUMBNAILS, $this->EditPageNrs)) !== false){
				unset($this->EditPageNrs[$pos]);
			}
		}
	}

	/**
	 * returns the javascript for the rollover function
	 *
	 * @return string
	 * @param string $src
	 * @param string $src_over
	 */
	function getRollOverScript($src = '', $src_over = '', $useScript = true){
		if(!$this->getElement('RollOverFlag')){
			return '';
		}

		if(!$this->getElement('name')){
			$this->setElement('name', 'ro_' . $this->Name, 'attrib');
		}

		$js = '
img' . self::$imgCnt . 'Over = new Image();
img' . self::$imgCnt . 'Out = new Image();
img' . self::$imgCnt . 'Over.src = "' . ($src_over? : f('SELECT Path FROM ' . FILE_TABLE . ' WHERE ID=' . intval($this->getElement('RollOverID')), '', $this->DB_WE)) . '";
img' . self::$imgCnt . 'Out.src = "' . ($src? : $this->Path) . '";';
		return ($useScript ? we_html_element::jsElement($js) : $js);
	}

	/**
	 * @return array
	 * @desc returns the rollover attribs as array
	 */
	function getRollOverAttribsArr($child = true){
		return $this->getElement('RollOverFlag') ? array(
			'onmouseover' => ($child ? 'if(this.firstChild){ this.firstChild' : '{this') . '.src = img' . self::$imgCnt . 'Over.src; }',
			'onmouseout' => ($child ? 'if(this.firstChild){ this.firstChild' : '{this') . '.src = img' . self::$imgCnt . 'Out.src;}',
			) :
			array();
	}

	/**
	 * resizes the image with the new $width & $height
	 *
	 * @return void
	 * @param int $width
	 * @param int $height
	 * @param int $quality
	 * @param bool $ratio
	 */
	function resizeImage($width, $height, $quality = 8, $ratio = false){
		if(!is_numeric($quality)){
			return false;
		}
		$quality = ($quality > 10 ? 10 : max($quality, 0)) * 10;
		$dataPath = TEMP_PATH . we_base_file::getUniqueId();
		$_resized_image = we_base_imageEdit::edit_image($this->getElement('data'), $this->getGDType(), $dataPath, $quality, $width, $height, $ratio);
		if(!$_resized_image[0]){
			return false;
		}
		$this->setElement('data', $dataPath);

		$this->setElement('width', $_resized_image[1], 'attrib');
		$this->setElement('origwidth', $_resized_image[1], 'attrib');

		$this->setElement('height', $_resized_image[2], 'attrib');
		$this->setElement('origheight', $_resized_image[2], 'attrib');

		$this->DocChanged = true;
		return true;
	}

	/**
	 * rotates the image with the new $width, $height and rotation angle
	 *
	 * @return void
	 * @param int $width
	 * @param int $height
	 * @param int $rotation
	 * @param int $quality
	 */
	function rotateImage($width, $height, $rotation, $quality = 8){
		if(!is_numeric($quality)){
			return false;
		}
		$quality = max(min($quality, 10), 0) * 10;

		$dataPath = TEMP_PATH . we_base_file::getUniqueId();
		$_resized_image = we_base_imageEdit::edit_image($this->getElement('data'), $this->getGDType(), $dataPath, $quality, $width, $height, false, true, 0, 0, -1, -1, $rotation);

		if(!$_resized_image[0]){
			return false;
		}
		$this->setElement('data', $dataPath);

		$this->setElement('width', $_resized_image[1], 'attrib');
		$this->setElement('origwidth', $_resized_image[1], 'attrib');

		$this->setElement('height', $_resized_image[2], 'attrib');
		$this->setElement('origheight', $_resized_image[2], 'attrib');

		$this->DocChanged = true;
		return true;
	}

	/**
	 * gets the HTML for including in HTML-Docs.
	 * If a thumbnail should displayed and it doesn't exists,
	 * it will be created automatically
	 *
	 * @return string
	 * @param boolean $dyn
	 * @param string $inc_href
	 */
	function getHtml($dyn = false, $inc_href = true, $pathOnly = false){
		$_data = $this->getElement('data');
		$only = $this->getElement('only');
		if($this->getElement('pathonly')){
			$only = 'path';
		}
		switch($only){
			case'id':
				return $this->ID;
			case 'path':
				return $this->Path;
		}
		if($this->ID || ($_data && !is_dir($_data) && is_readable($_data))){
			switch($this->getElement('LinkType')){
				case we_base_link::TYPE_INT:
					$href = f('SELECT Path FROM ' . FILE_TABLE . ' WHERE ID = ' . intval($this->getElement('LinkID')), '', $this->DB_WE);
					break;
				case we_base_link::TYPE_EXT:
					$href = $this->getElement('LinkHref');
					break;
				case we_base_link::TYPE_OBJ:
					$id = $this->getElement('ObjID');
					if(isset($GLOBALS['WE_MAIN_DOC'])){
						$pid = $GLOBALS['WE_MAIN_DOC']->ParentID;
					} else {
						$pidCvs = f('SELECT Workspaces FROM ' . OBJECT_FILES_TABLE . ' WHERE ID = ' . intval($id), '', $this->DB_WE);
						$foo = makeArrayFromCSV($pidCvs);
						$pid = ($foo ? $foo[0] : 0);
					}

					$path = isset($GLOBALS['WE_MAIN_DOC']) ? $GLOBALS['WE_MAIN_DOC']->Path : '';
					$href = we_objectFile::getObjectHref($this->getElement('ObjID'), $pid, $path, $this->DB_WE, TAGLINKS_DIRECTORYINDEX_HIDE, TAGLINKS_OBJECTSEOURLS); //FR #7711
					if(isset($GLOBALS['we_link_not_published'])){
						unset($GLOBALS['we_link_not_published']);
					}
					break;
				default:
					break;
			}

			$img_path = $this->Path;


			// we need to create a thumbnail - check if image exists
			if(($thumbname = $this->getElement('thumbnail')) && ($img_path && file_exists(WEBEDITION_PATH . '../' . $img_path))){
				$thumbObj = new we_thumbnail();
				if($thumbObj->initByThumbName($thumbname, $this->ID, $this->Filename, $this->Path, $this->Extension, 0, 0)){
					$img_path = $thumbObj->getOutputPath();

					if($thumbObj->isOriginal()){
//						$create = false;
					} elseif((!$thumbObj->isOriginal()) && file_exists(WEBEDITION_PATH . '../' . $img_path) &&
						// open a file
						intval(filectime(WEBEDITION_PATH . '../' . $img_path)) > intval($thumbObj->getDate())){
//						$create = false;
						//picture created after thumbnail definition was changed, so all is up-to-date
					} else {
						$thumbObj->createThumb();
					}

					if($this->getElement('width') != ''){//if width set to empty skip width attribute
						$this->setElement('width', $thumbObj->getOutputWidth(), 'attrib');
					}
					if($this->getElement('height') != ''){//if height set to empty skip height attribute
						$this->setElement('height', $thumbObj->getOutputHeight(), 'attrib');
					}
				}
			}

			if($pathOnly){
				return $img_path;
			}

			$target = $this->getElement('LinkTarget');

			$src = $dyn ?
				WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=show_binaryDoc&we_cmd[1]=' . $this->ContentType . '&we_cmd[2]=' . $GLOBALS['we_transaction'] . '&rand=' . microtime() :
				$img_path . '?m=' . $this->Published;

			if($this->issetElement('sizingrel')){
				$this->setElement('width', round($this->getElement('width') * $this->getElement('sizingrel')), 'attrib');
				$this->setElement('height', round($this->getElement('height') * $this->getElement('sizingrel')), 'attrib');
				$this->delElement('sizingrel');
			}

			if($this->issetElement('sizingbase')){
				$sizingbase = $this->getElement('sizingbase');
				$this->delElement('sizingbase');
			} else {
				$sizingbase = 16;
			}

			if($this->issetElement('sizingstyle')){
				$sizingstyle = $this->getElement('sizingstyle');
				$sizingstyle = $sizingstyle === 'none' ? false : $sizingstyle;
				$this->delElement('sizingstyle');
			} else {
				$sizingstyle = false;
			}

			if($sizingstyle){
				$style_width = round($this->getElement('width') / $sizingbase, 6);
				$style_height = round($this->getElement('height') / $sizingbase, 6);
				$newstyle = $this->getElement('style');

				$newstyle.=';width:' . $style_width . $sizingstyle . ';height:' . $style_height . $sizingstyle . ';';
				$this->setElement('style', $newstyle, 'attrib');
				$this->delElement('width');
				$this->delElement('height');
			}

			$this->resetElements();

			//  Here we generate the image-tag
			//   attribs for the image tag
			$attribs = array(
				'src' => $src
			);

			$filter = array('filesize', 'type', 'id', 'showcontrol', 'showthumbcontrol', 'thumbnail', 'href', 'longdescid', 'showimage', 'showinputs', 'listviewname', 'parentid', 'startid', 'origwidth', 'origheight', 'useMetaTitle'); //  dont use these array-entries

			if(defined('HIDENAMEATTRIBINWEIMG_DEFAULT') && HIDENAMEATTRIBINWEIMG_DEFAULT){
				$filter[] = 'name';
			}

			// check longdesc here - does file exist?
			if($this->getElement('longdescid') && $this->getElement('longdescid') != '-1'){
				$longdesc = id_to_path($this->getElement('longdescid'));
				$attribs['longdesc'] = $longdesc;
			}


			// $attribs['Title'] changed to $attribs['title'] to fix bug #5814
			if($this->getElement('useMetaTitle') && $this->getElement('Title') != ''){ //  set title if set in image
				$attribs['title'] = $this->getElement('Title');
			}

			while((list($k, $v) = $this->nextElement('attrib'))){
				if(!in_array($k, $filter)){
					if(!empty($v['dat'])){
						$attribs[$k] = $v['dat'];
					}
				}
			}

			$showAttrOnly = (!empty($attribs['only'])) ?
				$attribs['only'] :
				((!empty($attribs['pathonly'])) ?
					'src' :
					''
				);

			switch($showAttrOnly){
				case 'src':
				case 'alt':
				case 'width':
				case 'height':
					return $attribs[$showAttrOnly];
				case 'filename':
					return $this->Filename;
				case 'size':
					return we_base_file::getHumanFileSize($this->getFilesize());
				case 'extension':
					return $this->Extension;
				case 'parentpath':
					return $this->getParentPath();
				default:
					break;
			}

			if((!empty($href)) && $inc_href){ //  use link with rollover
				$aAtts = array(
					'href' => $href,
					'title' => isset($attribs['title']) ? $attribs['title'] : '',
				);

				if($target){
					$aAtts['target'] = $target;
				}
				if(isset($attribs['xml'])){
					$aAtts['xml'] = $attribs['xml'];
				}

				$aAtts = array_merge($aAtts, $this->getRollOverAttribsArr());

				$this->html = ( trim($this->getRollOverScript($src)) . getHtmlTag('a', $aAtts, getHtmlTag('img', $attribs)) );
			} else {
				$this->html = (defined('WE_EDIT_IMAGE')) ?
					we_base_imageCrop::getJS() . we_base_imageCrop::getCSS() . we_base_imageCrop::getCrop($attribs) :
					$this->getRollOverScript($src) . getHtmlTag('img', array_merge($attribs, $this->getRollOverAttribsArr(false)));
			}
		} else {
			if($pathOnly){
				//be compatible
				return '';
			}
			$xml = isset($attribs) ? weTag_getAttribute('xml', $attribs, false, we_base_request::BOOL) : true; //rest is done in getHtmlTag
			$attribs = array('style' => 'margin:8px 18px;border-style:none;width:64px;height:64px;',
				'src' => ICON_DIR . 'no_image.gif',
				'alt' => 'no-image',
				'xml' => $xml,
			);
			if(isset($this->name)){
				$attribs['name'] = $this->name;
			}

			$this->html = getHtmlTag('img', $attribs);
		}

		return $this->html;
	}

	/**
	 * function will determine the size of any GIF, JPG, PNG.
	 * This function uses the php Function with the same name.
	 * But the php function doesn't work with some images created from some apps.
	 * So this function uses the gd lib if nothing is returned from the php function
	 *
	 * @static
	 * @return array
	 * @param $filename complete path of the image
	 */
	function getimagesize($filename){
		return ($this->isSvg() ? $this->getSvgSize($filename) : we_thumbnail::getimagesize($filename));
	}

	private function getSvgSize($filename){
		$line = we_base_file::load($filename, 'rb', 1000, 1);
		$match = array();
		return array(
			(preg_match('|<svg[^>]*width="([^"]*)"[^>]*>|i', $line, $match) ? intval($match[1]) : ''),
			(preg_match('|<svg[^>]*height="([^"]*)"[^>]*>|i', $line, $match) ? intval($match[1]) : ''),
		);
	}

	/**
	 * Overwrites formInput2() in we:class.inc:
	 * Method adds parameter $text, which is used only if field-name in db and field-name in language files are different
	 *
	 * @return string
	 */
	function formInput2($width, $name, $size = 25, $type = 'txt', $attribs = '', $text = ''){
		$text = $text === '' ? $name : $text;
		return $this->formInputField($type, $name, (g_l('weClass', '[' . $text . ']', true) != false ? g_l('weClass', '[' . $text . ']') : $text), $size, $width, '', $attribs);
	}

	/**
	 * Returns the HTML for the properties part in the properties view
	 *
	 * @return string
	 */
	function formProperties(){
		// Create table
		$_content = new we_html_table(array('class' => 'default propertydualtable'), 5, 3);
		$row = 0;
		// Row 1
		$_content->setCol($row, 0, null, $this->formInputInfo2(155, 'width', 10, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"', "origwidth"));
		$_content->setCol($row, 1, null, $this->formInputInfo2(155, 'height', 10, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"', "origheight"));
		$_content->setCol($row++, 2, null, $this->formInput2(155, 'border', 10, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"'));


		// Row 2
		$_content->setCol($row, 0, null, $this->formInput2(155, 'align', 10, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"'));
		$_content->setCol($row, 1, null, $this->formInput2(155, 'hspace', 10, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"'));
		$_content->setCol($row++, 2, null, $this->formInput2(155, 'vspace', 10, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"'));


		// Row 3
		$_content->setCol($row, 0, array('colspan' => 3), $this->formInput2(328, 'alt', 23, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"'));
		$_content->setCol($row++, 2, null, $this->formInput2(155, 'name', 10, 'attrib', 'onchange="_EditorFrame.setEditorIsHot(true);"'));


		//	Row 4
		$_content->setCol($row, 0, array('colspan' => 3), $this->formInput2(328, 'title', 23, 'attrib', ($this->getElement('useMetaTitle') == 1 ? "readonly='readonly'" : "") . '" onchange="_EditorFrame.setEditorIsHot(true);"', 'Title'));

		$_titleField = 'we_' . $this->Name . '_attrib[title]';
		$_metaTitleField = 'we_' . $this->Name . '_txt[Title]';
		$useMetaTitle = 'we_' . $this->Name . '_attrib[useMetaTitle]';
		//	disable field 'title' when checked or not.   on checked true: document.forms[0]['$_titleField'].value='$this->getElement('Title')' and  onchecked false: document.forms[0]['$_titleField'].value='' added to fix bug #5814
		$_content->setCol($row++, 2, array('style' => 'vertical-align:bottom'), we_html_forms::checkboxWithHidden($this->getElement('useMetaTitle'), $useMetaTitle, g_l('weClass', '[use_meta_title]'), false, 'defaultfont', "if(this.checked){ document.forms[0]['" . $_titleField . "'].setAttribute('readonly', 'readonly', 'false'); document.forms[0]['" . $_titleField . "'].value = '" . $this->getElement('Title') . "'; }else{ document.forms[0]['" . $_titleField . "'].removeAttribute('readonly', 'false'); document.forms[0]['" . $_titleField . "'].value='';}_EditorFrame.setEditorIsHot(true);"));

		//  longdesc should be available in images.
		//    check if longdesc is set and get path
		$longdesc_id_name = 'we_' . $this->Name . '_attrib[longdescid]';
		$longdesc_text_name = 'tmp_longdesc';
		$longdesc_id = $this->getElement('longdescid');
		$longdescPath = ($longdesc_id ? id_to_path($longdesc_id) : '');

		$yuiSuggest = & weSuggest::getInstance();
		$yuiSuggest->setAcId('LonDesc');
		$yuiSuggest->setContentType('folder,' . we_base_ContentTypes::WEDOCUMENT . ',' . we_base_ContentTypes::HTML);
		$yuiSuggest->setInput($longdesc_text_name, $longdescPath);
		$yuiSuggest->setLabel(g_l('weClass', '[longdesc_text]'));
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(1);
		$yuiSuggest->setResult($longdesc_id_name, $longdesc_id);
		$yuiSuggest->setSelector(weSuggest::DocSelector);
		$yuiSuggest->setWidth(328);
		$cmd1 = "document.we_form.elements['" . $longdesc_id_name . "'].value";

		$yuiSuggest->setSelectButton(we_html_button::create_button(we_html_button::SELECT, "javascript:we_cmd('we_selector_image'," . $cmd1 . ",'" . FILE_TABLE . "','" . we_base_request::encCmd($cmd1) . "','" . we_base_request::encCmd("document.we_form.elements['" . $longdesc_text_name . "'].value") . "','" . we_base_request::encCmd("opener._EditorFrame.setEditorIsHot(true);opener.top.we_cmd('reload_editpage');") . "','','','" . we_base_ContentTypes::WEDOCUMENT . "," . we_base_ContentTypes::TEXT . "," . we_base_ContentTypes::HTML . "',1)"));
		$yuiSuggest->setTrashButton(we_html_button::create_button(we_html_button::TRASH, "javascript:document.we_form.elements['" . $longdesc_id_name . "'].value='-1';document.we_form.elements['" . $longdesc_text_name . "'].value='';_EditorFrame.setEditorIsHot(true); YAHOO.autocoml.setValidById('" . $yuiSuggest->getInputId() . "')"));
		$_content->setCol($row, 0, array('style' => 'vertical-align:bottom', 'colspan' => 5), $yuiSuggest->getHTML() . $yuiSuggest->getYuiJs());

		// Return HTML
		return $_content->getHtml();
	}

	/**
	 * Returns true if the gd lib supports the Type of the image
	 *
	 * @return boolean
	 */
	function gd_support(){
		return in_array($this->getGDType(), we_base_imageEdit::supported_image_types());
	}

	/**
	 * Returns the Type for the image to use for the gd library functions
	 *
	 * @return string
	 */
	function getGDType(){
		return isset(we_base_imageEdit::$GDIMAGE_TYPE[strtolower($this->Extension)]) ? we_base_imageEdit::$GDIMAGE_TYPE[strtolower($this->Extension)] : 'jpg';
	}

	function convert($type, $quality = 8){
		if(!is_numeric($quality)){
			return false;
		}
		list($width, $height) = $this->getOrigSize();
		$quality = max(min($quality, 10), 0) * 10;

		$dataPath = TEMP_PATH . we_base_file::getUniqueId();
		we_base_imageEdit::edit_image($this->getElement('data'), $type, $dataPath, $quality, $width, $height, false);

		$this->setElement('data', $dataPath);
		$this->Extension = '.' . $type;
		$this->Text = $this->Filename . $this->Extension;
		$this->Path = $this->getParentPath() . $this->Text;

		$this->DocChanged = true;
	}

	function getThumbnail($size = 150, $size2 = 200){
		if(!$this->getElement('data') || !is_readable($this->getElement('data'))){
			return $this->getHtml();
		}

		if($this->isSvg()){
			/* if(($w = $this->getElement('width')) && ($h = $this->getElement('height'))){
			  if(($tmpH = $h * ($size / $w)) <= $size2){
			  $size2 = $tmpH;
			  } else {
			  $size = $w * ($size2 / $h);
			  }
			  } */
			return '<image style="max-width:100px;max-height:100px;" src="' . WEBEDITION_DIR . 'showTempFile.php?file=' . str_replace(array($_SERVER['DOCUMENT_ROOT'], WEBEDITION_DIR), '', $this->getElement('data')) . '" />';
			//return '<svg id="' . we_base_file::getUniqueId() . '" height="' . intval($size2) . '" width="' . intval($size) . '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" ><image x="0" y="0" height="150" width="150"  xlink:href="' . WEBEDITION_DIR . 'showTempFile.php?file=' . str_replace(array($_SERVER['DOCUMENT_ROOT'], WEBEDITION_DIR), '', $this->getElement('data')) . '" /></svg>';
		}

		return '<img src="' . WEBEDITION_DIR . 'thumbnail.php?' . http_build_query(array(
				'id' => $this->ID,
				'size' => $size,
				'path' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->getElement('data')),
				'extension' => $this->Extension,
				'size2' => $size2)) . '" border="0" />';
	}

	protected function getMetaDataReader($force = false){
		return parent::getMetaDataReader(true);
	}

	function importMetaData($fieldsToImport = null, $importOnlyEmptyFields = false){
		$this->getMetaData();
		if(!isset($this->metaData) || !is_array($this->metaData)){
			return;
		}

		$_fields = array();

		// first we fetch all defined metadata fields from tblMetadata:
		$GLOBALS['DB_WE']->query('SELECT tag,type,importFrom FROM ' . METADATA_TABLE);
		while($GLOBALS['DB_WE']->next_record()){
			list($_fieldName, $_fieldType, $_importFrom) = $GLOBALS['DB_WE']->getRecord();
			$_fieldType = $_fieldType ? : 'textfield';

			$_parts = explode(',', $_importFrom);
			foreach($_parts as $_part){
				$_part = trim($_part);
				$_fieldParts = explode('/', $_part);
				if(count($_fieldParts) > 1){
					$_tagType = strtolower(trim($_fieldParts[0]));
					$_tagName = trim($_fieldParts[1]);
					if(!(isset($_fields[$_fieldName]) && is_array($_fields[$_fieldName]))){
						$_fields[$_fieldName] = array();
					}
					$_fields[$_fieldName][] = array($_tagType, $_tagName, $_fieldType);
				}
			}
		}

		$_typeMap = array('textfield' => 'txt', 'wysiwyg' => 'txt', 'textarea' => 'txt', 'date' => 'date');

		foreach($_fields as $fieldName => $_arr){
			$_fieldVal = $this->getElement($fieldName);

			if((is_null($fieldsToImport) || in_array($fieldName, array_keys($fieldsToImport))) && ($importOnlyEmptyFields == false || $_fieldVal === '')){
				foreach($_arr as $_impFr){
					if(isset($this->metaData[$_impFr[0]][$_impFr[1]]) && !empty($this->metaData[$_impFr[0]][$_impFr[1]])){
						$_val = $this->metaData[$_impFr[0]][$_impFr[1]];
						if($_impFr[2] === 'date'){
							// here we need to parse the date
							if(preg_match('|^(\d{4}):(\d{2}):(\d{2}) (\d{2}):(\d{2}):(\d{2})$|', $_val, $regs)){
								$_val = sprintf('%016d', mktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]));
							}
						}
						$this->setElement($fieldName, trim($_val), $_typeMap[$_impFr[2]]);
						break;
					}
				}
			}
		}
	}

	/**
	 * Returns the HTML for the link part in the properties view
	 *
	 * @return string
	 */
	function formLink(){
		$yuiSuggest = &weSuggest::getInstance();

		$textname = 'we_' . $this->Name . '_txt[LinkPath]';
		$idname = 'we_' . $this->Name . '_txt[LinkID]';
		$extname = 'we_' . $this->Name . '_txt[LinkHref]';
		$linkType = $this->getElement('LinkType') ? : 'no';
		$linkPath = f('SELECT Path FROM ' . FILE_TABLE . ' WHERE ID = ' . intval($this->getElement('LinkID')), '', $this->DB_WE);

		$RollOverFlagName = 'we_' . $this->Name . '_txt[RollOverFlag]';
		$RollOverFlag = $this->getElement('RollOverFlag') ? 1 : 0;
		$RollOverIDName = 'we_' . $this->Name . '_txt[RollOverID]';
		$RollOverID = $this->getElement('RollOverID') ? : '';
		$RollOverPathname = 'we_' . $this->Name . '_txt[RollOverPath]';
		$RollOverPath = f('SELECT Path FROM ' . FILE_TABLE . ' WHERE ID = ' . intval($RollOverID), '', $this->DB_WE);

		$checkFlagName = 'check_' . $this->Name . '_RollOverFlag';
		$cmd1 = "document.we_form.elements['" . $idname . "'].value";
		$but1 = we_html_button::create_button(we_html_button::SELECT, "javascript:we_cmd('we_selector_document', " . $cmd1 . ",'" . FILE_TABLE . "','" . we_base_request::encCmd($cmd1) . "','" . we_base_request::encCmd("document.we_form.elements['" . $textname . "'].value") . "','" . we_base_request::encCmd("opener._EditorFrame.setEditorIsHot(true);opener.document.we_form.elements['we_" . $this->Name . "_txt[LinkType]'][2].checked=true;") . "','',0,''," . (permissionhandler::hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ");");

		$cmd1 = "document.we_form.elements['" . $RollOverIDName . "'].value";
		$but2 = we_html_button::create_button(we_html_button::SELECT, "javascript:we_cmd('we_selector_image', " . $cmd1 . ",'" . FILE_TABLE . "','" . we_base_request::encCmd($cmd1) . "','" . we_base_request::encCmd("document.we_form.elements['" . $RollOverPathname . "'].value") . "','" . we_base_request::encCmd("opener._EditorFrame.setEditorIsHot(true);opener.document.we_form.elements['" . $RollOverFlagName . "'].value=1;opener.document.we_form.elements['" . $checkFlagName . "'].checked=true;") . "','',0,'" . we_base_ContentTypes::IMAGE . "'," . (permissionhandler::hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ");");


		$cmd1 = "document.we_form.elements['" . $extname . "'].value";
		$butExt = permissionhandler::hasPerm('CAN_SELECT_EXTERNAL_FILES') ?
			we_html_button::create_button(we_html_button::SELECT, "javascript:we_cmd('browse_server','" . we_base_request::encCmd($cmd1) . "',''," . $cmd1 . ",'" . we_base_request::encCmd("opener._EditorFrame.setEditorIsHot(true);opener.document.we_form.elements['we_" . $this->Name . "_txt[LinkType]'][1].checked=true;") . "')") : "";

		if(defined('OBJECT_TABLE')){
			$objidname = 'we_' . $this->Name . '_txt[ObjID]';
			$objtextname = 'we_' . $this->Name . '_txt[ObjPath]';
			$objPath = f('SELECT Path FROM ' . OBJECT_FILES_TABLE . ' WHERE ID = ' . intval($this->getElement('ObjID')), '', $this->DB_WE);
			$cmd1 = "document.we_form.elements['" . $objidname . "'].value";
			$butObj = we_html_button::create_button(we_html_button::SELECT, "javascript:we_cmd('we_selector_document'," . $cmd1 . ",'" . OBJECT_FILES_TABLE . "','" . we_base_request::encCmd($cmd1) . "','" . we_base_request::encCmd("document.we_form.elements['" . $objtextname . "'].value") . "','" . we_base_request::encCmd("opener._EditorFrame.setEditorIsHot(true);opener.document.we_form.elements['we_" . $this->Name . "_txt[LinkType]'][3].checked=true;") . "','','','objectFile'," . (permissionhandler::hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1) . ");");
		}

		// Create table
		$_content = new we_html_table(array('class' => 'default'), (defined('OBJECT_TABLE') ? 11 : 9), 2);
		$row = 0;
		// No link
		$_content->setCol($row, 0, array('style' => 'vertical-align:top;padding-bottom:10px;'), we_html_forms::radiobutton('no', ($linkType === 'no'), 'we_' . $this->Name . '_txt[LinkType]', g_l('weClass', '[nolink]'), true, 'defaultfont', '_EditorFrame.setEditorIsHot(true);'));
		$_content->setCol($row++, 1, null, '');

		// External link
		$_ext_link_table = new we_html_table(array('class' => 'default'), 1, 2);

		$_ext_link_table->setCol(0, 0, null, $this->htmlTextInput('we_' . $this->Name . '_txt[LinkHref]', 25, $this->getElement('LinkHref'), '', 'onchange="_EditorFrame.setEditorIsHot(true);"', "text", 280));
		$_ext_link_table->setCol(0, 1, null, $butExt);

		$_ext_link = "href" . we_html_element::htmlBr() . $_ext_link_table->getHtml();

		$_content->setCol($row, 0, array('style' => 'vertical-align:top;padding-bottom:10px;'), we_html_forms::radiobutton(we_base_link::TYPE_EXT, ($linkType == we_base_link::TYPE_EXT), 'we_' . $this->Name . '_txt[LinkType]', g_l('weClass', '[extern]'), true, 'defaultfont', '_EditorFrame.setEditorIsHot(true)'));
		$_content->setCol($row++, 1, array('class' => 'defaultfont', 'style' => 'vertical-align:top'), $_ext_link);


		// Internal link
		$yuiSuggest->setAcId('internalPath');
		$yuiSuggest->setContentType(implode(',', array(we_base_ContentTypes::FOLDER, we_base_ContentTypes::WEDOCUMENT, we_base_ContentTypes::IMAGE, we_base_ContentTypes::JS, we_base_ContentTypes::CSS, we_base_ContentTypes::HTML, we_base_ContentTypes::APPLICATION, we_base_ContentTypes::QUICKTIME)));
		$yuiSuggest->setInput($textname, $linkPath);
		$yuiSuggest->setResult($idname, $this->getElement('LinkID'));
		$yuiSuggest->setTable(FILE_TABLE);
		$yuiSuggest->setSelectButton($but1);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(0);
		$yuiSuggest->setWidth(280);
		$yuiSuggest->setSelector(weSuggest::DocSelector);
		$yuiSuggest->setLabel('href');
		$_int_link = $yuiSuggest->getHTML();

		$_content->setCol($row, 0, array('style' => 'vertical-align:top'), we_html_forms::radiobutton(we_base_link::TYPE_INT, ($linkType == we_base_link::TYPE_INT), 'we_' . $this->Name . '_txt[LinkType]', g_l('weClass', '[intern]'), true, 'defaultfont', '_EditorFrame.setEditorIsHot(true);'));
		$_content->setCol($row++, 1, array('class' => 'defaultfont', 'style' => 'vertical-align:top'), $_int_link);

		// Object link
		if(defined('OBJECT_TABLE')){

			$yuiSuggest->setAcId('objPathLink');
			$yuiSuggest->setContentType("folder," . we_base_ContentTypes::OBJECT_FILE);
			$yuiSuggest->setInput($objtextname, $objPath);
			$yuiSuggest->setResult($objidname, $this->getElement('ObjID'));
			$yuiSuggest->setTable(OBJECT_FILES_TABLE);
			$yuiSuggest->setSelectButton($butObj);
			$yuiSuggest->setMaxResults(10);
			$yuiSuggest->setMayBeEmpty(0);
			$yuiSuggest->setWidth(280);
			$yuiSuggest->setSelector(weSuggest::DocSelector);
			$yuiSuggest->setLabel('href');
			$_obj_link = $yuiSuggest->getHTML();


			$_content->setCol($row, 0, array('style' => 'vertical-align:top;padding-top:10px;'), we_html_forms::radiobutton(we_base_link::TYPE_OBJ, ($linkType == we_base_link::TYPE_OBJ), 'we_' . $this->Name . '_txt[LinkType]', g_l('linklistEdit', '[objectFile]'), true, 'defaultfont', '_EditorFrame.setEditorIsHot(true);'));
			$_content->setCol($row++, 1, array('class' => 'defaultfont', 'style' => 'vertical-align:top'), $_obj_link);
		}

		// Target
		$_content->setCol($row++, 0, array('colspan' => 2, 'class' => 'defaultfont', 'style' => 'vertical-align:top;padding:20px 0px;'), g_l('weClass', '[target]') . we_html_element::htmlBr() . we_html_tools::targetBox('we_' . $this->Name . '_txt[LinkTarget]', 33, 0, '', $this->getElement('LinkTarget'), '_EditorFrame.setEditorIsHot(true);', 20, 97));


		// Rollover image
		$yuiSuggest->setAcId('rollOverPath');
		$yuiSuggest->setContentType(implode(',', array(we_base_ContentTypes::FOLDER, we_base_ContentTypes::WEDOCUMENT, we_base_ContentTypes::IMAGE, we_base_ContentTypes::JS, we_base_ContentTypes::CSS, we_base_ContentTypes::HTML, we_base_ContentTypes::APPLICATION, we_base_ContentTypes::QUICKTIME)));
		$yuiSuggest->setInput($RollOverPathname, $RollOverPath);
		$yuiSuggest->setResult($RollOverIDName, $RollOverID);
		$yuiSuggest->setTable(FILE_TABLE);
		$yuiSuggest->setSelectButton($but2);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(0);
		$yuiSuggest->setWidth(280);
		$yuiSuggest->setSelector(weSuggest::DocSelector);
		$yuiSuggest->setLabel('href');
		$_rollover = $yuiSuggest->getHTML();

		$_content->setCol($row, 0, array('style' => 'vertical-align:top'), we_html_forms::checkbox(1, $RollOverFlag, $checkFlagName, 'Roll Over', false, 'defaultfont', "_EditorFrame.setEditorIsHot(true); this.form.elements['" . $RollOverFlagName . "'].value = (this.checked ? 1 : 0); ") . we_html_element::htmlHidden($RollOverFlagName, $RollOverFlag));
		$_content->setCol($row, 1, array('class' => 'defaultfont', 'style' => 'vertical-align:top'), $_rollover);

		return $_content->getHtml();
	}

	function hasMetaField($name){
		$_defined_fields = we_metadata_metaData::getDefinedMetaDataFields();
		foreach($_defined_fields as $field){
			if($field['tag'] === $name){
				return true;
			}
		}
		return false;
	}

	function formMetaInfos(){
		return '<table class="default">
	<tr><td style="padding-bottom:2px;">' . $this->formInputField('txt', 'Title', g_l('weClass', '[Title]'), 40, 508, '', "onchange=\"_EditorFrame.setEditorIsHot(true);\"") . '</td></tr>
	<tr><td style="padding-bottom:2px;">' . $this->formInputField('txt', 'Description', g_l('weClass', '[Description]'), 40, 508, '', "onchange=\"_EditorFrame.setEditorIsHot(true);\"") . '</td></tr>
	<tr><td style="padding-bottom:2px;">' . $this->formInputField('txt', 'Keywords', g_l('weClass', '[Keywords]'), 40, 508, '', "onchange=\"_EditorFrame.setEditorIsHot(true);\"") . '</td></tr>
</table>' .
			($this->ContentType == we_base_ContentTypes::IMAGE ? $this->formCharset(true) : '');
	}

	static function checkAndPrepare($formname, $key = 'we_document'){
		// check to see if there is an image to create or to change
		if(isset($_FILES['we_ui_' . $formname]) && is_array($_FILES['we_ui_' . $formname])){

			if(isset($_FILES['we_ui_' . $formname]['name']) && is_array($_FILES['we_ui_' . $formname]['name'])){
				foreach($_FILES['we_ui_' . $formname]['name'] as $imgName => $filename){
					$_imgDataId = we_base_request::_(we_base_request::STRING, 'WE_UI_IMG_DATA_ID_' . $imgName);

					if($_imgDataId !== false && isset($_SESSION[$_imgDataId])){
						$_SESSION[$_imgDataId]['doDelete'] = false;

						if(we_base_request::_(we_base_request::BOOL, 'WE_UI_DEL_CHECKBOX_' . $imgName)){
							$_SESSION[$_imgDataId]['doDelete'] = true;
							$_SESSION[$_imgDataId]['id'] = $_SESSION[$_imgDataId]['id'] ? : (intval($GLOBALS[$key][$formname]->getElement($imgName)) ? : 0);
						} elseif($filename){
							// file is selected, check to see if it is an image
							$ct = getContentTypeFromFile($filename);
							if($ct == we_base_ContentTypes::IMAGE){
								$imgId = intval($GLOBALS[$key][$formname]->getElement($imgName));

								// move document from upload location to tmp dir
								$_SESSION[$_imgDataId]['serverPath'] = TEMP_PATH . we_base_file::getUniqueId();
								move_uploaded_file($_FILES['we_ui_' . $formname]['tmp_name'][$imgName], $_SESSION[$_imgDataId]['serverPath']);

								$we_size = we_thumbnail::getimagesize($_SESSION[$_imgDataId]['serverPath']);

								if(empty($we_size)){
									unset($_SESSION[$_imgDataId]);
									return;
								}

								$tmp_Filename = $imgName . '_' . we_base_file::getUniqueId() . '_' .
									preg_replace('/[^A-Za-z0-9._-]/', '', $_FILES['we_ui_' . $formname]['name'][$imgName]);

								if($imgId){
									$_SESSION[$_imgDataId]['id'] = $imgId;
								}

								$_SESSION[$_imgDataId]['fileName'] = preg_replace('#^(.+)\..+$#', '$1', $tmp_Filename);
								$_SESSION[$_imgDataId]['extension'] = (strpos($tmp_Filename, '.') > 0) ?
									preg_replace('#^.+(\..+)$#', '$1', $tmp_Filename) : '';
								$_SESSION[$_imgDataId]['text'] = $_SESSION[$_imgDataId]['fileName'] . $_SESSION[$_imgDataId]['extension'];

								//image needs to be scaled
								if((isset(
										$_SESSION[$_imgDataId]['width']) && $_SESSION[$_imgDataId]['width']) || (isset(
										$_SESSION[$_imgDataId]['height']) && $_SESSION[$_imgDataId]['height'])){
									$imageData = we_base_file::load($_SESSION[$_imgDataId]['serverPath']);
									$thumb = new we_thumbnail();
									$thumb->init('dummy', $_SESSION[$_imgDataId]['width'], $_SESSION[$_imgDataId]['height'], $_SESSION[$_imgDataId]['keepratio'], $_SESSION[$_imgDataId]['maximize'], false, false, '', 'dummy', 0, '', '', $_SESSION[$_imgDataId]['extension'], $we_size[0], $we_size[1], $imageData, '', $_SESSION[$_imgDataId]['quality']);

									$imgData = '';
									$thumb->getThumb($imgData);

									we_base_file::save($_SESSION[$_imgDataId]['serverPath'], $imageData);

									$we_size = we_thumbnail::getimagesize($_SESSION[$_imgDataId]['serverPath']);
								}

								$_SESSION[$_imgDataId]['imgwidth'] = $we_size[0];
								$_SESSION[$_imgDataId]['imgheight'] = $we_size[1];
								$_SESSION[$_imgDataId]['type'] = $_FILES['we_ui_' . $formname]['type'][$imgName];
								$_SESSION[$_imgDataId]['size'] = $_FILES['we_ui_' . $formname]['size'][$imgName];
							}
						}
					}
				}
			}
		}
	}

	public function getPropertyPage(){
		echo we_html_multiIconBox::getJS() .
		we_html_multiIconBox::getHTML('PropertyPage', array(
			array("icon" => "path.gif", "headline" => g_l('weClass', '[path]'), "html" => $this->formPath(), "space" => 140),
			array("icon" => "doc.gif", "headline" => g_l('weClass', '[document]'), "html" => $this->formIsSearchable() . $this->formIsProtected(), "space" => 140),
			array("icon" => "meta.gif", "headline" => g_l('weClass', '[metainfo]'), "html" => $this->formMetaInfos(), "space" => 140),
			array("icon" => "navi.gif", "headline" => g_l('global', '[navigation]'), "html" => $this->formNavigation(), "space" => 140),
			array("icon" => "cat.gif", "headline" => g_l('global', '[categorys]'), "html" => $this->formCategory(), "space" => 140),
			array("icon" => "user.gif", "headline" => g_l('weClass', '[owners]'), "html" => $this->formCreatorOwners(), "space" => 140),
			array("icon" => "hyperlink.gif", "headline" => g_l('weClass', '[hyperlink]'), "html" => $this->formLink(), "space" => 140),
		));
	}


// #AH2015#
	public function formImageFocus() {
		$name = $GLOBALS['we_doc']->Name;
		$id = $GLOBALS['we_doc']->ID;
		$path = urlencode(WEBEDITION_DIR.'/site'.$GLOBALS['we_doc']->Path);
		$extension = $GLOBALS['we_doc']->Extension;
		$xfocus = $this->getElement('xfocus');
		$yfocus = $this->getElement('yfocus');
		$out = <<<HERE
<input type="number" name="we_{$name}_input[xfocus]" id="x_focus" value="0" step="0.01" min="-1" max="1" onchange="_EditorFrame.setEditorIsHot(true);" />
<input type="number" name="we_{$name}_input[yfocus]" id="y_focus" value="0" step="0.01" min="-1" max="1" onchange="_EditorFrame.setEditorIsHot(true);" />
<div id="imgfocus_wrap" style="width:300px;background-color:#dddddd;">
	<img src="/webEdition/thumbnail.php?id={$id}&size=300&size2=100&path={$path}&extension={$extension}" style="width:100%;" />
	<div id="imgfocus_point"></div>
</div>
<script>
	// Code sollte in doc-ready rein
	var x_focus = document.getElementById("x_focus");
	var y_focus = document.getElementById("y_focus");
	var imgfocus_wrap = document.getElementById("imgfocus_wrap");
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
	x_focus.value = ({$xfocus}).toFixed(2);
	y_focus.value = ({$yfocus}).toFixed(2);
	imgfocus_point.style.left = (((x_focus.value*owidth)+owidth)/2)+"px";
	imgfocus_point.style.top = (((y_focus.value*oheight)+oheight)/2)+"px";
</script>
<style>
	#imgfocus_wrap {position:relative;cursor:hand;}
	#imgfocus_point {width:0px;height:0px;position:absolute;border:1px solid white;border-radius:50%;box-shadow:0 0 0 1px black;}
	#imgfocus_point:before {content:"";display:block;position:absolute;left:-16px;top:-16px;width:30px;height:30px;border:1px solid white;border-radius:50%;box-shadow:0 0 0 1px black;}
</style>
HERE;
		//$out .= '<script>alert(JSON.stringify('.json_encode($GLOBALS['we_doc']).'));</script>';
		return $out;
	}
// #AH2015#

}
