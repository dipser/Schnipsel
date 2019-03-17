<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function build($type, $conf) {  print_r($conf);echo '<br>';
  include_once '../thumb.class.php';
  //$id = $conf['id'];
  //$filename = VEVI_DIR_UPLOADS . $this->upload_id_to_path($id);
  $filename = dirname(__FILE__).'/example.jpg';

  $t = new ThumbImage($filename);

  $width = (isset($conf['width'])) ? $conf['width'] : 'auto';
  $height = (isset($conf['height'])) ? $conf['height'] : 'auto';
  $t->setCanvas($width, $height);

  if (isset($conf['size'])) {
    $t->setSize($conf['size']);
  }
  /*
  3. bild verschieben zum fokuspunkt/position
    if position = center center -> x und y in px berechnen
    if position = 10% 10% -> x und y in px berechnen
    verschieben soweit es geht!
  */
  if (isset($conf['position'])) {
    $t->setPosition($conf['position']);
  }

  $t->resize();

  $dir = pathinfo($filename, PATHINFO_DIRNAME);
  $fil = pathinfo($filename, PATHINFO_FILENAME);
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  $newfilestr = $fil.$t->getThumbStr().'.'.$ext;

  $t->save($dir.'/'.$newfilestr, IMAGETYPE_JPEG, null);

  return $newfilestr;

}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Thumb Klasse</title>
  <style>
  *, *::before, *::after {box-sizing:border-box;}

  .cssimg::before, .thumbimg::before {
    position: absolute;
    top:100%;left:0;
    content:'';
    display: block;
    width:100%;
    border:1px solid black;
  }

  .cssimg {
    position: relative;
  	display:inline-block;
  	border:1px solid blue;
  	width:200px;
  	height:200px;
  	background-image:url('./example.jpg');
    background-repeat: no-repeat;
    margin-bottom:20px;
  }
  .cssimg::before {
    content:'CSS';
    border:1px solid blue;
  }

  .thumbimg {
    position: relative;
  	display:inline-block;
  	border:1px solid red;
    margin-bottom:20px;
  	width:200px;
  	height:200px;
  }
  .thumbimg img {display:block;}
  .thumbimg::before {
    content:'Thumb';
    border:1px solid red;
  }
  </style>
</head>
<body>
  <h1>Thumb Klasse</h1>

  	Contain:<br>
    <?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'contain')); ?><br>
  	<div class="cssimg" style="background-size:contain;"></div>
    <div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	Cover:<br>
    <?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'cover')); ?><br>
    <div class="cssimg" style="background-size:cover;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	auto (auto auto):<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'auto')); ?><br>
    <div class="cssimg" style="background-size:auto;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	auto 50%:<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'auto 50pct')); ?><br>
    <div class="cssimg" style="background-size:auto 50%;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	50% (50% auto):<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'50pct')); ?><br>
    <div class="cssimg" style="background-size:50%;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	50% 50%:<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'50pct 50pct')); ?><br>
    <div class="cssimg" style="background-size:50% 50%;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	50px (50px auto):<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'50px')); ?><br>
    <div class="cssimg" style="background-size:50px;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	auto 50px:<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'auto 50px')); ?><br>
    <div class="cssimg" style="background-size:auto 50px;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>
  	50px 50px:<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'50px 50px')); ?><br>
    <div class="cssimg" style="background-size:50px 50px;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>

    <hr>
    Cover und (position: 50% 50%):<br>
    <?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'cover', 'position'=>'50pct 50pct')); ?><br>
    <div class="cssimg" style="background-size:cover;background-position:50% 50%;"></div>
    <div class="thumbimg"><img src="<?=$filename?>"></div>
    <hr>
  	auto (auto auto) und (position: 50% 50%):<br>
  	<?php $filename = build('thumb', array('id'=>15, 'width'=>200, 'height'=>200, 'size'=>'auto', 'position'=>'50pct 50pct')); ?><br>
    <div class="cssimg" style="background-size:auto;background-position:50% 50%;"></div>
  	<div class="thumbimg"><img src="<?=$filename?>"></div>
  	<hr>


</body>
</html>
