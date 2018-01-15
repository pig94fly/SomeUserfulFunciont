<?php
  /**
   *缩略图生成代码，可在服务器保存图片时同步生成缩略图，或者在需要时调用生成缩略图;
   *缩略图名称为thumb_‘源图片名称’;
   */
  class MakeThumbnail
  {

    public function getImageName($img_dest)
    {
      $img_info = getimagesize($img_dest);      //获取图片宽高；
      $img_pinfo = pathinfo($img_dest);        //获取dir相对地址和文件名；
      $thumbnail_info = array('x' => 160, 'y' => 120);          //缩略图宽高（px）；
      if ($img_info[0]>$thumbnail_info['x']||$img_info[1]>$thumbnail_info['y']) {  //在源图片分辨率大于设定缩略图大小时方生成缩略图；
        $times['x'] = $img_info[0]/$thumbnail_info['x'];
        $times['y'] = $img_info[1]/$thumbnail_info['y'];
        $thumbnail_size = $this->dealAndCompare($times,$img_info);        //调用函数计算缩略图实际大小；
        $this->createThumbnail($thumbnail_size,$img_pinfo,$img_info);       //生成并保存缩略图；
      }else {
        $destination = __DIR__.'/'.$img_pinfo['dirname'].'/'.$img_pinfo['basename'];
        $thumb_destination = __DIR__.'/'.$img_pinfo['dirname'].'/thumbnail_'.$img_pinfo['basename'];
        $image = $this->openImage($img_info,$destination);
        imagejpeg($image,$thumb_destination);
        imagedestroy($image);
        echo '原图过小，直接作为缩略图';
      }
    }

    public function dealAndCompare($times,$img_info)        //计算缩略图大小；
    {
      if ($times['x']>$times['y']) {
        $y = $img_info[1]/$times['x'];
        $thumbnail_size = array('x' =>160,'y' => $y);
      }else {
        $x = $img_info[0]/$times['y'];
        $thumbnail_size = array('x' => $x,'y' => 120);
      }
      return $thumbnail_size;
    }

    public function createThumbnail($thumbnail_size,$img_pinfo,$img_info)       //生成缩略图；
    {
      $destination = __DIR__.'/'.$img_pinfo['dirname'].'/'.$img_pinfo['basename'];
      $img_thum = imagecreatetruecolor($thumbnail_size['x'],$thumbnail_size['y']);
      $image = $this->openImage($img_info,$destination);
      imagecopyresampled($img_thum,$image,0,0,0,0,$thumbnail_size['x'],$thumbnail_size['y'],$img_info[0],$img_info[1]);
      $thumb_destination = __DIR__.'/'.$img_pinfo['dirname'].'/thumbnail_'.$img_pinfo['basename'];
      imagejpeg($img_thum,$thumb_destination);
      imagedestroy($img_thum);
      imagedestroy($image);
    }

    public function openImage($img_info = null,$destination)        //根据原图格式打开图片；
    {
      switch ($img_info[2])
      {
        case 1:
        $simage =imagecreatefromgif($destination);
        break;
        case 2:
        $simage =imagecreatefromjpeg($destination);
        break;
        case 3:
        $simage =imagecreatefrompng($destination);
        break;
        case 6:
        $simage =imagecreatefromwbmp($destination);
        break;
        default:
        die("不支持的文件类型");
        exit;
     }
     return $simage;
    }
  }

?>
