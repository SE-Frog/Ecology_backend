<?php
    //主機IP位置
    $host = 'localhost';
    //使用者名稱(*需與MySQL帳號相同)
    $user = 'root';
    //使用者密碼(*需與MySQL密碼相同, 沒有密碼可以留空)
    $pass = '';
    //要使用的資料庫(*請填入已經匯入資料的資料庫名稱)
    $db = 'ecology';
    //使用上述資料與MySql建立連線, 如果連線失敗(die)則顯示'Error with MySQL connection'
    $conn = mysqli_connect($host, $user, $pass, $db) or die('Error with MySQL connection');
    //設定編碼格式
    mysqli_query($conn,"SET NAMES utf8");
?>