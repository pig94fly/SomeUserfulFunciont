<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/31
 * Time: 9:35
 */

namespace App\Model;


class DeleteFile
{
    public static function deleteFile($path)
    {
        unlink($path);
    }
    static function deletePath($path)
    {
        if (!is_dir($path)){
            if (is_file($path))
                unlink($path);
            return true;
        }
        $dir = opendir($path);
        while ($file=readdir($dir)){
            if ($file!='.'&&$file!='..'){
                if (is_dir($file)){
                    self::deletePath("{$path}/{$file}");
//                    rmdir("{$path}/{$file}");
                }else{
                    unlink("{$path}/{$file}");
                }
            }
        }
        rmdir($path);
    }
}
