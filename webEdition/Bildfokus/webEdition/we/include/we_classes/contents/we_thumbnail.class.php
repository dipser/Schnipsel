<?php
/**
 * webEdition CMS
 *
 * $Rev: 10362 $
 * $Author: mokraemer $
 * $Date: 2015-08-27 15:49:08 +0200 (Thu, 27 Aug 2015) $
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
 * Class we_thumbnail
 *
 * Provides functions for creating and handling webEdition thumbnails.
 */
class we_thumbnail{
	const OK = 0;
	const USE_ORIGINAL = 1;
	const BUILDERROR = 2;
	const NO_GDLIB_ERROR = 3;
	const INPUTFORMAT_NOT_SUPPORTED = 4;

	/**
	 * ID of the thumbnail
	 * @var int
	 */
	private $thumbID = 0;

	/**
	 * Width of the thumbnail
	 * @var int
	 */
	private $thumbWidth = '';

	/**
	 * Height of the thumbnail
	 * @var int
	 */
	private $thumbHeight = '';

	/**
	 * Quality of the jpg thumbnail
	 * @var int
	 */
	private $thumbQuality = 8;

	/**
	 * Ratio (keep ratio) of the thumbnail
	 * @var boolean
	 */
	private $thumbRatio = true;

	/**
	 * Maxsize of the thumbnail
	 * @var boolean
	 */
	private $thumbMaxsize = true;

	/**
	 * create thumbnail in interlaced mode
	 * @var boolean
	 */
	private $thumbInterlace = true;

	/**
	 * Fitinside of the thumbnail
	 * @var smallint
	 */
	private $thumbFitinside = false;

	/**
	 * Format (jpg, png or gif) of the thumbnail
	 * @var string
	 */
	private $thumbFormat = '';

	/**
	 * Name of the thumbnail
	 * @var string
	 */
	private $thumbName = '';

	/**
	 * ID of the image
	 * @var int
	 */
	private $imageID = 0;

	/**
	 * Filename of the image
	 * @var string
	 */
	private $imageFileName = '';

	/**
	 * Path of the image
	 * @var string
	 */
	private $imagePath = '';

	/**
	 * Extension of the image
	 * @var string
	 */
	private $imageExtension = '';

	/**
	 * width of the image
	 * @var int
	 */
	private $imageWidth = 0;

	/**
	 * height of the image
	 * @var int
	 */
	private $imageHeight = 0;

	/**
	 * binaryData of the image (is mostly empty)
	 * @var string
	 */
	private $imageData = '';

	/**
	 * date of the thumb last saved in thumbnails table
	 * @var int
	 */
	private $date = '';

	/**
	 * db Object of the thumbnail
	 * @var object
	 */
	private $db;

	/**
	 * format (jpg, png or gif) of the generated thumbnail
	 * @var string
	 */
	private $outputFormat = 'jpg';

	/**
	 * path of the generated thumbnail
	 * @var string
	 */
	private $outputPath = '';

	/**
	 * width of the generated thumbnail
	 * @var int
	 */
	private $outputWidth = 0;

	/**
	 * height of the generated thumbnail
	 * @var int
	 */
	private $outputHeight = 0;

	/**
	 * defines, that even when the original is smaller than desired size, and image should not be maximized, a thumb is generated, needed for Bug #4258: upload of customer image
	 * @var bool
	 */
	private $generateSmaller = false;

// #AH2015#
	private $xfocus = 0;
	private $yfocus = 0;
// #AH2015#

	/**
	 * Constructor of class
	 *
	 * @return we_thumbnail
	 */
	public function __construct(){
		$this->db = new DB_WE();
	}

	/**
	 * main initializer
	 *
	 * @return void
	 * @param int $thumbID
	 * @param int $thumbWidth
	 * @param int $thumbHeight
	 * @param boolean $thumbRatio
	 * @param boolean $thumbMaxsize
	 * @param boolean $thumbInterlace
	 * @param string $thumbFormat
	 * @param string $thumbName
	 * @param int $imageID
	 * @param string $imageFileName
	 * @param string $imagePath
	 * @param string $imageExtension
	 * @param int $imageWidth
	 * @param int $imageHeight
	 * @param string $imageData
	 * @param int $date
	 * @public
	 */
	public function init($thumbID, $thumbWidth, $thumbHeight, $thumbRatio, $thumbMaxsize, $thumbInterlace, $thumbFitinside, $thumbFormat, $thumbName, $imageID, $imageFileName, $imagePath, $imageExtension, $imageWidth, $imageHeight, $imageData = "", $date = "", $thumbQuality = 8, $generateSmaller = false){
		$this->thumbID = $thumbID;
		$this->thumbWidth = $thumbWidth;
		$this->thumbHeight = $thumbHeight;
		$this->thumbQuality = $thumbQuality;
		$this->thumbRatio = trim($thumbRatio) ? $thumbRatio : 0;
		$this->thumbMaxsize = trim($thumbMaxsize) ? $thumbMaxsize : 0;
		$this->thumbInterlace = trim($thumbInterlace) ? $thumbInterlace : 0;
		$this->thumbFitinside = trim($thumbFitinside) ? $thumbFitinside : 0;
		$this->thumbFormat = trim($thumbFormat);
		$this->thumbName = $thumbName;
		$this->imageID = $imageID;
		$this->imageFileName = $imageFileName;
		$this->imagePath = $imagePath;
		$this->imageExtension = $imageExtension;
		$this->imageWidth = $imageWidth;
		$this->imageHeight = $imageHeight;
		$this->imageData = $imageData;
		$this->date = $date;
		$this->generateSmaller = $generateSmaller;
		if($this->thumbID && $this->thumbName){
			$this->outputFormat = $this->thumbFormat ? : (isset(we_base_imageEdit::$GDIMAGE_TYPE[strtolower($this->imageExtension)]) ? we_base_imageEdit::$GDIMAGE_TYPE[strtolower($this->imageExtension)] : 'jpg');
			$this->checkAndGetImageSizeIfNeeded();
			$this->setOutputPath();
			$this->calculateOutsize();
		}
		// #AH2015#
		//$this->xfocus = -1;
		//$this->yfocus = 1;
		$this->getImageData();
		// #AH2015#
	}

	/**
	 * initializer if you have all image data and a thumb ID
	 *
	 * @return void
	 * @param int $thumbID
	 * @param int $imageID
	 * @param string $imageFileName
	 * @param string $imagePath
	 * @param string $imageExtension
	 * @param int $imageWidth
	 * @param int $imageHeight
	 * @param string $imageData
	 * @public
	 */
	public function initByThumbID($thumbID, $imageID, $imageFileName, $imagePath, $imageExtension, $imageWidth, $imageHeight, $imageData = ''){
		$_foo = getHash('SELECT * FROM ' . THUMBNAILS_TABLE . ' WHERE ID=' . intval($thumbID), $this->db);
		$this->init($thumbID, isset($_foo['Width']) ? $_foo['Width'] : 0, isset($_foo['Height']) ? $_foo['Height'] : 0, isset($_foo['Ratio']) ? $_foo['Ratio'] : 0, isset($_foo['Maxsize']) ? $_foo['Maxsize'] : 0, isset($_foo['Interlace']) ? $_foo['Interlace'] : false, isset($_foo['Fitinside']) ? $_foo['Fitinside'] : false, isset($_foo['Format']) ? $_foo['Format'] : '', isset($_foo['Name']) ? $_foo['Name'] : '', $imageID, $imageFileName, $imagePath, $imageExtension, $imageWidth, $imageHeight, $imageData, isset($_foo['Date']) ? $_foo['Date'] : '', isset($_foo['Quality']) ? $_foo['Quality'] : '');
	}

	/**
	 * initializer if you have all image data and a thumb name
	 *
	 * @return void
	 * @param int $thumbName
	 * @param int $imageID
	 * @param string $imageFileName
	 * @param string $imagePath
	 * @param string $imageExtension
	 * @param int $imageWidth
	 * @param int $imageHeight
	 * @param string $imageData
	 * @public
	 */
	public function initByThumbName($thumbName, $imageID, $imageFileName, $imagePath, $imageExtension, $imageWidth, $imageHeight, $imageData = ''){
		$_foo = getHash('SELECT * FROM ' . THUMBNAILS_TABLE . ' WHERE Name="' . $this->db->escape($thumbName) . '"', $this->db);
		$_foo = $_foo ? : array(
			'ID' => 0,
			'Width' => 0,
			'Height' => 0,
			'Ratio' => 0,
			'Maxsize' => 0,
			'Interlace' => false,
			'Fitinside' => false,
			'Format' => '',
			'Name' => '',
			'Date' => '',
			'Quality' => ''
		);
		$this->init($_foo['ID'], $_foo['Width'], $_foo['Height'], $_foo['Ratio'], $_foo['Maxsize'], $_foo['Interlace'], $_foo['Fitinside'], $_foo['Format'], $_foo['Name'], $imageID, $imageFileName, $imagePath, $imageExtension, $imageWidth, $imageHeight, $imageData, $_foo['Date'], $_foo['Quality']);
		return ($this->thumbID && $this->thumbName);
	}

	/**
	 * initializer if you have only a image ID and a thumb ID
	 *
	 * @return bool
	 * @param int $imageID
	 * @param int $thumbID
	 * @param boolean $getBinary if set, also the binary image data will be loaded
	 * @public
	 */
	public function initByImageIDAndThumbID($imageID, $thumbID, $getBinary = false){
		$this->imageID = $imageID;

		if(!$this->getImageData($getBinary)){
			return false;
		}
		$_foo = getHash('SELECT Width,Height,Ratio,Maxsize,Interlace,Fitinside,Format,Name,Date FROM ' . THUMBNAILS_TABLE . ' WHERE ID=' . intval($thumbID), $this->db)? : array(
			'Width' => 0,
			'Height' => 0,
			'Ratio' => 0,
			'Maxsize' => 0,
			'Interlace' => false,
			'Fitinside' => false,
			'Format' => '',
			'Name' => '',
			'Date' => '',
		);

		$this->init($thumbID, $_foo['Width'], $_foo['Height'], $_foo['Ratio'], $_foo['Maxsize'], $_foo['Interlace'], $_foo['Fitinside'], $_foo['Format'], $_foo['Name'], $imageID, $this->imageFileName, $this->imagePath, $this->imageExtension, $this->imageWidth, $this->imageHeight, $this->imageData, $_foo['Date']);
		return true;
	}

	public function getDate(){
		return $this->date;
	}

	/**
	 * creates the thumbnail and saves it in $this->outputPath
	 *
	 * @return int (WE_THUMB_OK, WE_THUMB_BUILDERROR, WE_THUMB_USE_ORIGINAL or WE_THUMB_NO_GDLIB_ERROR;
	 * @public
	 */
	public function createThumb(){//echo '<script>console.log('.json_encode($this->xfocus).');</script>';
		if(we_base_imageEdit::gd_version() <= 0){
			return self::NO_GDLIB_ERROR;
		}
		$tmp = explode('.', $this->imagePath);
		$type = we_base_imageEdit::$GDIMAGE_TYPE['.' . strtolower(end($tmp))];
		if($this->useOriginalSize() && $this->outputFormat == $type){
			return self::USE_ORIGINAL;
		}

		if(!we_base_imageEdit::is_imagetype_read_supported($type)){
			return self::INPUTFORMAT_NOT_SUPPORTED;
		}

		$_thumbdir = self::getThumbDirectory(true);
		if(!file_exists($_thumbdir)){
			we_base_file::createLocalFolder($_thumbdir);
		}
		$quality = max(10, min(100, intval($this->thumbQuality) * 10));
// #AH2015#
		$outarr = we_base_imageEdit::edit_image($this->imageData ? : WEBEDITION_PATH . '../' . $this->imagePath, $this->outputFormat, WEBEDITION_PATH . '../' . $this->outputPath, $quality, $this->thumbWidth, $this->thumbHeight, $this->thumbRatio, $this->thumbInterlace, $this->xfocus, $this->yfocus, -1, -1, 0, $this->thumbFitinside);
// #AH2015#

		return $outarr[0] ? self::OK : self::BUILDERROR;
	}

	public function exists(){
		return !$this->isOriginal() && file_exists($this->getOutputPath(true));
	}

	/**
	 * creates the thumbnail and sets the binary data of the thumb to $thumbDataPointer
	 *
	 * @return int (WE_THUMB_OK, WE_THUMB_BUILDERROR, WE_THUMB_USE_ORIGINAL or WE_THUMB_NO_GDLIB_ERROR;
	 * @param string &$thumbDataPointer Pointer to a string
	 * @public
	 */
	public function getThumb(&$thumbDataPointer){
		if(we_base_imageEdit::gd_version() <= 0){
			return self::NO_GDLIB_ERROR;
		}

		if($this->useOriginalSize()){
			return self::USE_ORIGINAL;
		}
		$quality = $this->thumbQuality < 1 ? 10 : ($this->thumbQuality > 10 ? 100 : $this->thumbQuality * 10);
		$outarr = we_base_imageEdit::edit_image($this->imageData ? : $_SERVER["DOCUMENT_ROOT"] . $this->imagePath, $this->outputFormat, "", $quality, $this->thumbWidth, $this->thumbHeight, $this->thumbRatio, $this->thumbInterlace, 0, 0, -1, -1, 0, $this->thumbFitinside);
		if($outarr[0]){
			$thumbDataPointer = $outarr[0];
			return self::OK;
		}

		return self::BUILDERROR;
	}

	/**
	 * Gets the Directory for thumbnails
	 *
	 * @static
	 * @public
	 * @return str
	 * @param bool $realpath  if set to true, Document_ROOT will be appended before
	 */
	public static function getThumbDirectory($realpath = false){
		$dir = '/' . ltrim(preg_replace('#^\.?(.*)$#', '$1', (WE_THUMBNAIL_DIRECTORY ? : '_thumbnails_')), '/');
		return ($realpath ? WEBEDITION_PATH . '../' : '') . $dir;
	}

	/**
	 * function will determine the size of any GIF, JPG, PNG.
	 * This function uses the php Function with the same name.
	 * But the php function doesn't work with some images created from some apps.
	 * So this function uses the gd lib if nothing is returned from the php function
	 *
	 * @static
	 * @public
	 * @return array
	 * @param $filename complete path of the image
	 */
	public static function getimagesize($filename){
		$arr = @getimagesize($filename);

		if(isset($arr) && is_array($arr) && (count($arr) >= 4) && $arr[0] && $arr[1]){
			return $arr;
		}
		return (we_base_imageEdit::gd_version() ?
				we_base_imageEdit::getimagesize($filename) :
				$arr);
	}

	/**
	 * returns the output path
	 *
	 * @return string
	 * @public
	 */
	public function getOutputPath($withDocumentRoot = false, $unique = false){
		return ($withDocumentRoot ? WEBEDITION_PATH . '../' : '') .
			$this->outputPath .
			((!$withDocumentRoot && $unique ) ? '?t=' . ($this->exists() ? filemtime(WEBEDITION_PATH . '../' . $this->outputPath) : time()) :
				'');
	}

	/**
	 * returns the output width
	 *
	 * @return int
	 * @public
	 */
	public function getOutputWidth(){
		return $this->outputWidth;
	}

	/**
	 * returns the output Height
	 *
	 * @return int
	 * @public
	 */
	public function getOutputHeight(){
		return $this->outputHeight;
	}

	/**
	 * returns the name of tje thumbnail
	 *
	 * @return string
	 * @public
	 */
	public function getThumbName(){
		return $this->thumbName;
	}

	/**
	 * returns true if thumbnail is the same as the original image
	 *
	 * @return boolean
	 * @public
	 */
	public function isOriginal(){
		return $this->outputPath == $this->imagePath;
	}

	/**
	 * sets the output path for the thumbnail.
	 * if image must not be resized, it will set the path of the original image
	 *
	 * @return void
	 * @private
	 */
	private function setOutputPath(){
		if(
			( (!$this->useOriginalSize()) || (!$this->hasOriginalType() ) ) &&
			we_base_imageEdit::gd_version() > 0 &&
			we_base_imageEdit::is_imagetype_supported($this->outputFormat) &&
			we_base_imageEdit::is_imagetype_read_supported(
				isset(we_base_imageEdit::$GDIMAGE_TYPE[strtolower($this->imageExtension)]) ?
					we_base_imageEdit::$GDIMAGE_TYPE[strtolower($this->imageExtension)] : ''
			)
		){
			$this->outputPath = self::getThumbDirectory() . '/' . $this->imageID . '_' . $this->thumbID . '_' . $this->imageFileName . '.' . $this->outputFormat;
		} else {
			$this->outputPath = $this->imagePath;
		}
	}

	/**
	 * calculates the real size of the thumbnail (width & height)
	 *
	 * @return void
	 * @private
	 */
	private function calculateOutsize(){
		if($this->useOriginalSize()){
			$this->outputWidth = $this->imageWidth;
			$this->outputHeight = $this->imageHeight;
			return;
		}

		$this->outputWidth = 0;
		$this->outputHeight = 0;


		// If width has been specified set it and compute new height based on source area aspect ratio
		if($this->thumbWidth){
			$this->outputWidth = $this->thumbWidth;
			$this->outputHeight = $this->imageWidth ? round($this->imageHeight * $this->thumbWidth / $this->imageWidth) : 0;
		}

		// If height has been specified set it.
		// If width has already been set and the new image is too tall, compute a new width based
		// on aspect ratio - otherwise, use height and compute new width
		if($this->thumbHeight){
			if($this->outputHeight > $this->thumbHeight || $this->outputHeight == 0){
				$this->outputWidth = $this->imageHeight ? round($this->imageWidth * $this->thumbHeight / $this->imageHeight) : 0;
				$this->outputHeight = $this->thumbHeight;
			}
		}

		// Check, if we must discard aspect ratio
		if(!$this->thumbRatio && ($this->thumbWidth) && ($this->thumbHeight)){
			$this->outputWidth = $this->thumbWidth;
			$this->outputHeight = $this->thumbHeight;
		}

		// Check if it will fitinside
		if($this->thumbFitinside && ($this->thumbWidth) && ($this->thumbHeight)){
			$this->outputWidth = $this->thumbWidth;
			$this->outputHeight = $this->thumbHeight;
		}
	}

	/**
	 * checks if the thumbnail has the same size as the original image
	 *
	 * @return boolean
	 * @private
	 */
	private function useOriginalSize(){
		return ($this->generateSmaller ?
				false :
				($this->thumbMaxsize == false) && ($this->thumbFitinside == false) && (($this->imageWidth <= $this->thumbWidth) || $this->thumbWidth == 0) && (($this->imageHeight <= $this->thumbHeight) || $this->thumbHeight == 0));
	}

	/**
	 * checks if the thumbnail has the same extension as the original image
	 *
	 * @return boolean
	 */
	private function hasOriginalType(){
		return (strtolower($this->imageExtension) === '.' . $this->outputFormat);
	}

	/**
	 * get the image data
	 *
	 * @return void
	 * @private
	 */
	private function getImageData($getBinary = false){
		$this->db->query('SELECT l.Name,c.Dat FROM ' . CONTENT_TABLE . ' c JOIN ' . LINK_TABLE . ' l ON c.ID=l.CID WHERE l.DID=' . intval($this->imageID) .
			' AND l.DocumentTable="tblFile"');

		while($this->db->next_record()){
			if($this->db->f('Name') === 'origwidth'){
				$this->imageWidth = $this->db->f('Dat');
			} else if($this->db->f('Name') === 'origheight'){
				$this->imageHeight = $this->db->f('Dat');
			}
			// #AH2015#
			if($this->db->f('Name') === 'xfocus'){
				$this->xfocus = $this->db->f('Dat');
			}
			if($this->db->f('Name') === 'yfocus'){
				$this->yfocus = $this->db->f('Dat');
			}
			// #AH2015#
		}

		$imgdat = getHash('SELECT ID,Filename,Extension,Path FROM ' . FILE_TABLE . ' WHERE ID=' . intval($this->imageID), $this->db);
		if(!$imgdat){
			return false;
		}
		$this->imageFileName = $imgdat['Filename'];
		$this->imagePath = $imgdat['Path'];
		$this->imageExtension = $imgdat['Extension'];

		if($getBinary){
			$this->getBinaryData();
		}
		return true;
	}

	/**
	 * sets width & height of the image if width & height are empty
	 *
	 * @return void
	 * @private
	 */
	private function checkAndGetImageSizeIfNeeded(){
		if(!($this->imageWidth && $this->imageHeight)){
			$arr = $this->getimagesize(WEBEDITION_PATH . '../' . $this->imagePath);
			if(count($arr) >= 2){
				$this->imageWidth = $arr[0];
				$this->imageHeight = $arr[1];
			}
		}
	}

	/**
	 * loads the binary image data
	 *
	 * @return void
	 * @private
	 */
	private function getBinaryData(){
		$this->imageData = we_base_file::load(WEBEDITION_PATH . '../' . $this->imagePath);
	}

	public static function deleteByThumbID($id){
		$thumbsdir = self::getThumbDirectory(true);
		$dir_obj = @dir($thumbsdir);
		$filestodelete = array();
		if($dir_obj){
			while(false !== ($entry = $dir_obj->read())){
				if($entry != '.' && $entry != '..' && preg_match('|^[0-9]+_' . intval($id) . '_(.+)|', $entry)){
					$filestodelete[] = $thumbsdir . "/" . $entry;
				}
			}
			foreach($filestodelete as $p){
				we_base_file::deleteLocalFile($p);
			}
		}
	}

	public static function deleteByImageID($id){
		$thumbsdir = self::getThumbDirectory(true);
		$dir_obj = @dir($thumbsdir);
		$filestodelete = array();
		if($dir_obj){
			while(false !== ($entry = $dir_obj->read())){
				switch($entry){
					case '.':
					case '..':
						continue;
					default:
						if(substr($entry, 0, strlen($id) + 1) == $id . '_'){
							$filestodelete[] = $thumbsdir . '/' . $entry;
						}
				}
			}
		}
		$previewDir = WE_THUMB_PREVIEW_PATH;
		$dir_obj = @dir($previewDir);
		if($dir_obj){
			while(false !== ($entry = $dir_obj->read())){
				switch($entry){
					case '.':
					case '..':
						continue;
					default:
						if(substr($entry, 0, strlen($id) + 1) == $id . "_" || substr($entry, 0, strlen($id) + 1) == $id . '.'){
							$filestodelete[] = $previewDir . '/' . $entry;
						}
				}
			}
		}
		foreach($filestodelete as $p){
			we_base_file::deleteLocalFile($p);
		}
	}

}
