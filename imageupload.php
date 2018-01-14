<meta content="text/html;charset=utf-8" http-equiv="content-type">

<?php

  $upload_types = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
  $img_maxsize = 2000000;     //2000000byte;
  $destination_folder = 'image/  ';      //upload folder;
  $watermark  =1;      //是否附加水印(1为加水印,其他为不加水印);
  $watertype = 1;      //水印类型(1为文字,2为图片)
  $waterposition = 1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
  $waterstring = "edu.com";  //水印字符串
  $waterimg = "xplore.gif";    //水印图片
  $imgpreview = 1;      //是否生成预览图(1为生成,其他为不生成);
  $imgpreviewsize = 1/2;    //缩略图比例
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>图片上传</title>
  </head>
  <body>
    <form enctype="multipart/form-data" method="post">
      <input type="file" name="img_upload" value="点击选择图片">
      <input type="submit" name="submit" value="SUB">
    </form>
  </body>
</html>


<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!is_uploaded_file($_FILES['img_upload']['tmp_name'])) {
      echo "图片不存在";
      exit;
    }

    $file = $_FILES['img_upload'];

    if (!in_array($file['type'],$upload_types)) {
      echo "非正确格式图片";
      exit;
    }

    if (!file_exists($destination_folder)) {
      mkdir($destination_folder);
    }

    $filename=$file["tmp_name"];
    $image_size = getimagesize($filename);
    $pinfo=pathinfo($file["name"]);
    $ftype=$pinfo['extension'];
    $md5_name = md5($file['name']);
    $destination = $destination_folder.$md5_name.md5($md5_name).".".$ftype;
    if (file_exists($destination) && $overwrite != true)
    {
        echo "同名文件已经存在了";
        exit;
    }

    if(!move_uploaded_file ($filename, $destination))
    {
        echo "移动文件出错";
        exit;
    }

    $pinfo=pathinfo($destination);
    $fname=$pinfo[basename];
    echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";
    echo " 宽度:".$image_size[0];
    echo " 长度:".$image_size[1];
    echo "<br> 大小:".$file["size"]." bytes";

    if($watermark==1)
    {
        $iinfo=getimagesize($destination,$iinfo);
        $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
        $white=imagecolorallocate($nimage,255,255,255);
        $black=imagecolorallocate($nimage,0,0,0);
        $red=imagecolorallocate($nimage,255,0,0);
        imagefill($nimage,0,0,$white);
        switch ($iinfo[2])
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
       imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
       imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);

        switch($watertype)
        {
            case 1:   //加水印字符串
            imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
            break;
            case 2:   //加水印图片
            $simage1 =imagecreatefromgif("xplore.gif");
            imagecopy($nimage,$simage1,0,0,0,0,85,15);
            imagedestroy($simage1);
            break;
        }

        switch ($iinfo[2])
        {
            case 1:
            //imagegif($nimage, $destination);
            imagejpeg($nimage, $destination);
            break;
            case 2:
            imagejpeg($nimage, $destination);
            break;
            case 3:
            imagepng($nimage, $destination);
            break;
            case 6:
            imagewbmp($nimage, $destination);
            //imagejpeg($nimage, $destination);
            break;
        }

        //覆盖原上传文件
        imagedestroy($nimage);
        imagedestroy($simage);
        }

        if($imgpreview==1)
        {
        echo "<br>图片预览:<br>";
        echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
        echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";
        }

  }
?>
