<?php
  session_start();

// 首先生成验证字符，这里先区分大小写;

  function createString($amount=4)    //生成预订数额的字符串，大小写
  {
    $string = '';
    $strgroup = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for ($i=0,$length=strlen($strgroup); $i < $amount; $i++) {
        $string = $string.$strgroup[rand(0,$length-1)];
    }
    return $string;
  }

  //生成画布，生成字符颜色，生成干扰，header输出验证码，生成session;
  $amount = 4;                            //验证码字数
  $authsize = array('x'=>100,'y'=>30);
  $string = createString($amount);         //生成验证码字符;
  $_SESSION['authcode'] = $string;        //session赋值验证码;
  $authimg = imagecreatetruecolor($authsize['x'],30);
  $white = imagecolorallocate($authimg,255,255,255);
  imagefill($authimg,0,0,$white);
  for ($i=0; $i < $amount; $i++) {
    $strcolor[] = imagecolorallocate($authimg,rand(0,120),rand(0,120),rand(0,120));
  }
  for ($i=0; $i < $amount; $i++) {
    $x = rand(0,$authsize['x']/$amount-10)+$i*$authsize['x']/$amount;
    $y = rand(5,15);
    imagestring($authimg,60,$x,$y,$string[$i],$strcolor[$i]);
  }
  for ($i=0; $i < $amount; $i++) {
    $pointcolor[] = imagecolorallocate($authimg,rand(50,200),rand(50,200),rand(50,200));
  }
  for ($i=0; $i < 200; $i++) {
    imagesetpixel($authimg,rand(2,115),rand(2,28),$pointcolor[rand(0,$amount-1)]);
  }
  for ($i=0; $i < 3; $i++) {
    $x = array(rand(0,$authsize['x']),rand(0,$authsize['x']));
    $y = array(rand(0,$authsize['y']),rand(0,$authsize['y']));
    $linecolor = imagecolorallocate($authimg,rand(100,200),rand(100,200),rand(100,200));
    imageline($authimg,$x[0],$x[1],$y[0],$y[1],$linecolor);
  }


  header('Content-Type:image/png');
  imagepng($authimg);
  imagedestroy($authimg);
 ?>
