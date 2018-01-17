<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>多图上传test</title>
  </head>
  <body>
    <form enctype="multipart/form-data" method="post">
      图片上传：
      <input type="file" name="multi_img[]" value='点击'>
      <input type="file" name="multi_img[]">
      <input type="submit" value="SUB">
    </form>
  </body>
</html>
<?php
  $allow_type = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');

  /**
   *算法;
   */

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['multi_img'];
    $dealimage = new dealAndCompare;

  }


  /**
   *
   */
  class DealAndSaveImg extends AnotherClass
  {
    public function saveImage($file,$image_folder,$watermark=null)
    {
      if ($img_num = count($file['name'] > 1)) {
        $img_info = $this->splitFile($file,$img_num);    //分拆数组;
        $error = $this->saveMultiImg($img_info);        //保存图片;
        if($watermark != null){
          $this->addWater($img_info,$watermark,$error);
        }

      }
    }

    public function splitFile($file,$img_num)         //分拆file数组;
    {
      for ($i=0; $i < $img_num,$allow_type); $i++) {
        if (in_array($file['type'][$i]) {
          $image_info[$i] = array(
            'name' => $file['name'][$i],
            'tmp_name' => $file['tmp_name'][$i],);
        }
        return $image_info;
      }
    }

    public function saveMultiImg($file)
    {
      foreach ($file as $key => $image) {
        $destination = $this->getImageDest($image);
        if(!move_uploaded_file($image['tmp_name'],$destination)){
          $error[] = $image['name'];
        }else {
          $file[$key]['real_dest'] = $destination;
        }
      }
      if (is_array($error)) {
        return $error;
      }else {
        return 0;
      }
    }

    public function getImageDest($file)
    {
      $pathinfo = pathinfo($file['name']);
      $md5_imgname = md5($file['name']);
      return $destination = __DIR__.'/'.$image_folder.md5($md5_imgname).$md5_imgname.$pathinfo['extension'];
    }

    public function addWater($file,$water,$error)
    {
      if (is_array($error)) {
        foreach ($file as $key => $value) {
          if (in_array($value['name'],$error)) {
            unset($file[$key]);
          }
        }
      }
      switch ($water) {
        case 1:       //加图片水印
          # code...
          break;

        default:
          # code...
          break;
      }


    }

  }
