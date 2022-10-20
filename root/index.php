<?php
include '../DatabaseTool.php';
$databaseTool = new DatabaseTool();
$connect = $databaseTool->connect();
function formatTime($time){
    return date("Y-m-d H:i:s",$time);
}

if ($connect==0){
    //数据库连接成功
    //获取今天0点的时间
    header("content-type: text/html; charset=utf-8");
    $mktime = mktime(0, 0, 0, date("m"), date("d"), date("y"));
    echo "查询".date("Y-m-d H:i:s",$mktime)."以前提交的数据(即今日没有提交的人)";
    echo "<br/><br/><a href='downloadPic.php' style='font-size: 10pt;border: 0;background-color: cornflowerblue;color: white;text-decoration: none;padding: 5px;margin-top: 10px;margin-bottom: 10px;border-radius: 5px'>下载所有截图</a><br><br>";
    $mysqli_result = $databaseTool->query($mktime);
    if ($mysqli_result){
        $all = $mysqli_result->fetch_all();
        if ($all > 0){
            echo "<table border='1' cellpadding='0' rules='all'>";
            echo "<tr>";
            echo "<td>姓名</td>";
            echo "<td>学号</td>";
            echo "<td>最后提交时间</td>";
            echo "</tr>";
            for ($i=0;$i<sizeof($all);$i++){
                $var = $all[$i];
                echo "<tr>";
                echo "<td>$var[0]</td>";
                echo "<td>$var[1]</td>";
                echo "<td>".formatTime($var[2])."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "今天全部交齐了";
        }
    }else{
        echo "查询失败";
    }
}else{
    echo "数据库连接失败";
}