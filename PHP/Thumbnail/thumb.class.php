<?php
/*
 * File: ThumbImage.php
 * Author: Aurelian Hermand
 * Date: 17.03.2019
 */
class ThumbImage {
  // Original
  var $image;
  var $image_filename; // Dateipfad
  var $image_type; // Dateityp
  var $image_width;
  var $image_height;

  // Thumb
  var $thumb;
  var $thumb_permission = null; // CHMOD permission
  var $thumb_quality = 75; // 0 - 100
  var $thumb_type; // IMAGETYPE_JPEG | IMAGETYPE_PNG | IMAGETYPE_GIF
  var $thumb_cwidth; // auto | <pixel>
  var $thumb_cheight; // auto | <pixel>
  var $thumb_size = 'auto auto'; // Hintergrund-Abmessungen wie CSS background-size: [ <length-percentage> | auto ]{1,2} | cover | contain
  var $thumb_position = '0pct 0pct'; // Fokuspunkt wie CSS background-position
  var $thumb_trimcanvas = true; // Canvas beschneiden

  function __construct($filename) {
    $this->image_filename = $filename;
    $image_info = getimagesize($filename);
    $this->image_type = $image_info[2];
    if( $this->image_type == IMAGETYPE_JPEG ) {
      $this->image = imagecreatefromjpeg($filename);
    } elseif( $this->image_type == IMAGETYPE_GIF ) {
      $this->image = imagecreatefromgif($filename);
    } elseif( $this->image_type == IMAGETYPE_PNG ) {
      $this->image = imagecreatefrompng($filename);
    }
    $this->image_width = $this->getWidth();
    $this->image_height = $this->getHeight();
    $this->thumb_type = $image_info[2];
    return $this;
  }
  function save($filename) {
    if( $this->thumb_type == IMAGETYPE_JPEG ) {
      imagejpeg($this->thumb, $filename, $this->thumb_quality);
    } elseif( $this->thumb_type == IMAGETYPE_GIF ) {
      imagegif($this->thumb, $filename);
    } elseif( $this->thumb_type == IMAGETYPE_PNG ) {
      imagepng($this->thumb, $filename);
    }
    if( $this->thumb_permission != null) {
      chmod($filename, $this->thumb_permission);
    }
  }
  function output() {
    if( $this->thumb_type == IMAGETYPE_JPEG ) {
      imagejpeg($this->thumb);
    } elseif( $this->thumb_type == IMAGETYPE_GIF ) {
      imagegif($this->thumb);
    } elseif( $this->thumb_type == IMAGETYPE_PNG ) {
      imagepng($this->thumb);
    }
  }

  function getWidth() {
    return imagesx($this->image);
  }
  function getHeight() {
    return imagesy($this->image);
  }
  function getThumbStr() {
    $arr = array(
      'cw' => $this->thumb_cwidth,
      'ch' => $this->thumb_cheight,
      'size' => $this->thumb_size,
      'pos' => $this->thumb_position,
      'tc' => $this->thumb_trimcanvas
    );
    $str = '';
    foreach ($arr as $key => $val) {
      $str .= '_'.$key.'-'.$val;
    }
    return $str;
  }

  function setCanvas($width, $height) {
    $this->thumb_cwidth = ($width!='auto') ? (int)$width : $this->getWidth();
    $this->thumb_cheight = ($height!='auto') ? (int)$height : $this->getHeight();
  }
  function setQuality($quality) {$this->thumb_quality = (int)$quality;}
  function setSize($size) {$this->thumb_size = trim($size);}
  function setPosition($position) {$this->thumb_position = trim($position);}
  function setTrimCanvas($bool) {$this->thumb_trimcanvas = $bool;}

  function resize() {
    /*
    image skalieren und ausrichten
      if size = 50% 50% -> bild auf 50% breite und 50% höhe des canvas skalieren/verzerren
      if size = 50px 50px -> bild auf 50px breite und 50px höhe skalieren/verzerren
      if size = "auto" or "auto auto" -> originalgrösse
      if size = cover -> breite und höhe anpassen
      if size = contain -> breite und höhe anpassen
    */
    $size = explode(' ', $this->thumb_size);
    $size_width = 0;
    $size_height = 0;
    $width_ratio = $this->thumb_cwidth / $this->image_width;
    $height_ratio = $this->thumb_cheight / $this->image_height;
    if ( count($size) >= 1 ) {
      if ($size[0] == 'contain') {
        if ( $width_ratio <= $height_ratio ) {
          $size_width = $this->thumb_cwidth;
          $size_height = $this->image_height * $width_ratio;
        } else {
          $size_width = $this->image_width * $height_ratio;
          $size_height = $this->thumb_cheight;
        }
      }
      if ($size[0] == 'cover') {
        if ( $width_ratio >= $height_ratio ) {
          $size_width = $this->thumb_cwidth;
          $size_height = $this->image_height * $width_ratio;
        } else {
          $size_width = $this->image_width * $height_ratio;
          $size_height = $this->thumb_cheight;
        }
      }
      if ($size[0] == 'auto') {
        $size_width = $this->image_width;
        $size_height = $this->image_height;
      }
      if ((bool)strpos($size[0], 'pct')) {
        $percentage = (int)$size[0] / 100;
        $size_width = $this->image_width * $width_ratio * $percentage;
        $size_height = $this->image_height * $width_ratio * $percentage;
      }
      if ((bool)strpos($size[0], 'px')) {
        $pixel = (int)$size[0];
        $width_ratio = $pixel / $this->image_width;
        $size_width = $pixel;
        $size_height = $this->image_height * $width_ratio;
      }
    }
    if (count($size)>=2) {
      if ((bool)strpos($size[1], 'pct')) {
        $percentage = (int)$size[1] / 100;
        $size_height = $this->image_height * $height_ratio * $percentage;
        if ($size[0] == 'auto') {
          $size_width = $this->image_width * $height_ratio * $percentage;
        }
      }
      if ((bool)strpos($size[1], 'px')) {
        $pixel = (int)$size[1];
        $size_height = $pixel;
        if ($size[0] == 'auto') {
          $height_ratio = $pixel / $this->image_height;
          $size_width = $this->image_width * $height_ratio;
        }
      }
    }


    $thumb_cwidth = ($this->thumb_trimcanvas && $this->thumb_cwidth>$size_width) ? $size_width : $this->thumb_cwidth;
    $thumb_cheight = ($this->thumb_trimcanvas && $this->thumb_cheight>$size_height) ? $size_height : $this->thumb_cheight;

    $this->thumb = imagecreatetruecolor($thumb_cwidth, $thumb_cheight);
    //print_r(array($size_width, $size_height));


    // Verschiebung zum Fokuspunkt
    $x_pct_position = (int)explode(' ', $this->thumb_position)[0];
    $y_pct_position = (int)explode(' ', $this->thumb_position)[1];
    $x_position = 0 - (($size_width-$thumb_cwidth)*($x_pct_position/100));
    $y_position = 0 - (($size_height-$thumb_cheight)*($y_pct_position/100));

    //imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
    /*
    dst_image     Resource des Zielbildes.
    src_image     Resource des Quellbildes.
    dst_x         x-coordinate of destination point.
    dst_y         y-coordinate of destination point.
    src_x         x-coordinate of source point.
    src_y         y-coordinate of source point.
    dst_w         Destination width.
    dst_h         Destination height.
    src_w         Breite der Quelle.
    src_h         Höhe der Quelle.
    */
    imagecopyresampled(
      $this->thumb,
      $this->image,
      $x_position, $y_position,
      0, 0,
      $size_width, $size_height,
      //$this->thumb_cwidth, $this->thumb_cheight,
      $this->image_width, $this->image_height
    );
  }
}
?>
