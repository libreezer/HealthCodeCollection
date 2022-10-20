<?php
//文件夹名称
//网站网址
//TODO:修改压缩包文件存放路径
$host = "localhost:6553/root";
$SaveFileName = "22级4班健康码截图";
$scandir = scandir("../".$SaveFileName);
//清除所有压缩文件
$scandir1 = scandir(".");
foreach ($scandir1 as $item){
    //截取
    $substr = substr($item, strlen($item) - 4, strlen($item));
    if ($substr === ".zip"){
        unlink($item);
    }
}
if ($scandir == false){
    echo "下载失败";
}else{
    if ($scandir > 0){
        $ZipFileName = "22级4班".date("m月d日").".zip";
        $zipArchive = new ZipArchive();
        $zipArchive->open($ZipFileName,ZipArchive::CREATE);
        $array_diff = array_diff($scandir, array('.', '..'));
        foreach ($array_diff as $item){
            $file =  "../".$SaveFileName."/".$item;
            $localfile = "22级4班".date("m月d日")."/".$item;
            echo $file;
            if (is_file($file)){
                $zipArchive->addFile($file,$localfile);
            }
        }
        $zipArchive->close();
        header("location://${host}/${ZipFileName}");
    }else{
        echo "没有发现截图";
    }
}