  // 造画布
   $im = imagecreatetruecolor(80,30);
   $white = imagecolorallocate($im,255,255,255);
   imagefill($im,0,0,$white);

  // 造随机字体颜色
  $color = imagecolorallocate($im,rand(0,125),rand(0,125),rand(0,125));

  // 造线条的随机颜色
  $line1 = imagecolorallocate($im,rand(100,125),rand(100,125),rand(100,125));
  $line2 = imagecolorallocate($im,rand(100,125),rand(100,125),rand(100,125));
  $line3 = imagecolorallocate($im,rand(100,125),rand(100,125),rand(100,125));

  // 在画布上画线条
  imageline($im,rand(0,50),rand(0,25),rand(0,50),rand(0,25),$line1);
  imageline($im,rand(0,50),rand(0,20),rand(0,50),rand(0,20),$line2);
  imageline($im,rand(0,50),rand(0,20),rand(0,50),rand(0,20),$line3);

  // 在画布上写字
  $str = '';
  $strgroup = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  for ($i=0,$length=strlen($strgroup); $i < 4; $i++) {
      $str = $str.$strgroup[rand(0,$length-1)];
  }
  /*
  *array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
  */
  imagettftext($im,25,5,15,28,$color,'/home/zzq-pc/www/test/stb.ttf',$str);


  //输出
  ob_clean();
  header('Content-Type:image/png');
  imagepng($im);

  //销毁画布
  imagedestroy($im);
