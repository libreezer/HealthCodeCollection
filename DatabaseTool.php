<?php

class DatabaseTool
{
    //TODO:修改数据库连接
    static $host = "localhost:6553";//核心
    static $userName = "s9271372";
    static $password = "258369";
    static $mysqli;

    public function connect(){
        self::$mysqli = mysqli_connect(self::$host, self::$userName, self::$password) or die("连接数据库失败");
        if (self::$mysqli){
            //数据库连接成功
            mysqli_select_db(self::$mysqli,"s9271372");
            mysqli_query(self::$mysqli,"set names utf8");
        }
        return mysqli_connect_errno();
    }

    private function getTime(){
        return time();
    }

    public function insert($studentName,$studentID){
        $studentName="'${studentName}'";
        $sql_cmd = "insert into s9271372.healthcodecollecting values(".$studentName.",".$studentID.",".$this->getTime().")";
        mysqli_query(self::$mysqli, $sql_cmd);
        return mysqli_errno(self::$mysqli);
    }

    public function update($studentID){
        $sql_cmd = "update s9271372.healthcodecollecting set UnixTime=".$this->getTime()." where ID=123";
        mysqli_query(self::$mysqli,$sql_cmd);
        return mysqli_errno(self::$mysqli);
    }

    public function query($time){
        $sql_cmd = "select Name,ID,UnixTime from healthcodecollecting where UnixTime < ${time}";
        return mysqli_query(self::$mysqli,$sql_cmd);
    }

    public function checkIsExist($studentID){
        $sql_cmd = "select ID from healthcodecollecting where ID=${studentID}";
        $mysqli_result = mysqli_query(self::$mysqli,$sql_cmd);
        $sizeof = sizeof($mysqli_result->fetch_all());
        if ($sizeof>0){
            return true;
        }
        return false;
    }
}