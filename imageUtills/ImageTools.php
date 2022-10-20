<?php


class ImageTools
{

    private static $font = "imageUtills/font.ttf";
    private static $textSize = 70;
    private static $circleSize = 0;


    public static function drawTextOnPicture($filename,$text){
        $imagecreatefromjpeg = imagecreatefromjpeg($filename);
        //文本颜色
        $imagecolorallocate = imagecolorallocate($imagecreatefromjpeg, 186, 40, 53);
        imagefttext($imagecreatefromjpeg,self::$textSize,self::$circleSize,100,400,
            $imagecolorallocate,realpath(self::$font),$text);
        imagejpeg($imagecreatefromjpeg,$filename);
        imagedestroy($imagecreatefromjpeg);
    }
}