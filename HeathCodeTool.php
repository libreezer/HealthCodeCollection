<?php
$studentID = $_POST['StudentID'];
$studentName = $_POST['StudentName'];
$healthCode = $_FILES['HealthCode'];
//文件
$Filename = $healthCode['name'];
$FileError = $healthCode['error'];

//引入数据库操作
include 'DatabaseTool.php';
include 'imageUtills/ImageTools.php';

$databaseTool = new DatabaseTool();

//判断学号
if ($studentID == "") {
    echo "请输入学号！";
    return;
}
//判断姓名
if ($studentName == "") {
    echo "请输入姓名！";
    return;
}
//判断截图文件
if ($FileError != 0) {
    echo "上传截图失败！";
    return;
}
//文件夹名称
$SaveFileName = "22级4班健康码截图";
//$SaveFileName = "22级4班".date("m月d日");
if (is_dir($SaveFileName) == false) {
    mkdir($SaveFileName);
}
//创建数据库:create table healthcodecollecting(Name text,ID bigint unique,UnixTime bigint)
$connect = $databaseTool->connect();
if ($connect == 0) {
    $checkIsExist = $databaseTool->checkIsExist($studentID);
    //已存在学号
    if ($checkIsExist) {
        $fileSavePath = $SaveFileName . "/" . $studentID . ".jpg";
        $move_uploaded_file = move_uploaded_file($healthCode['tmp_name'], $fileSavePath);
        ImageTools::drawTextOnPicture($fileSavePath, "${studentID} ${studentName}");
        if ($move_uploaded_file == true) {
            $update = $databaseTool->update($studentID);
            if ($update == 0) {
                echo "<h1 style='color: green;font-size: 40pt'>提交成功!!!</h1>";
                return;
            } else {
                echo "<h1 style='color: red;font-size: 40pt'>数据更新失败</h1>";
                echo "<p style='color: red;font-size: 40pt'>请手动发送截图给班长，抱歉!</p>";
            }
        } else {
            echo "<h1 style='color: red;font-size: 40pt'>提交失败:</h1>";
            echo "<p style='color: red;font-size: 40pt'>请手动发送截图给班长，抱歉!</p>";
            echo error_get_last()['message'];
        }
    } else {
        echo "<h1 style='color: red;font-size: 40pt'>数据查询失败</h1>";
        echo "<p style='color: red;font-size: 40pt'>没有找到该学号</p>";
        echo "<p style='color: red;font-size: 40pt'>请手动发送截图给班长，抱歉!</p>";
    }
} else {
    echo "<h1 style='color: red;font-size: 40pt'>数据库连接失败</h1>";
    echo "<p style='color: red;font-size: 40pt'>请手动发送截图给班长，抱歉!</p>";
}