<?php
$SuID = $_SESSION['uID'];
require("dbconnect.php");

/* CREATE */
  function addUser($username='', $password='') {
    global $conn;
    if ($username > ' ') {
      //基本安全處理
      $username=mysqli_real_escape_string($conn, $username);
      $password=mysqli_real_escape_string($conn, $password);
      
      //Generate SQL
      $sql = "INSERT INTO `userinfo` (`username`, `password`) VALUES ('$username', '$password');";
      return mysqli_query($conn, $sql); //執行SQL
    } else {
      return false;
    }
  }


/* READ */
  function getUserList() {
    global $conn;
    // 從資料庫抓取所有user的資料，並依ID順序排列
    $sql = "SELECT * FROM `userinfo` ORDER BY id ASC";
    return mysqli_query($conn, $sql);
  }

  function userDetails($id) {
    global $conn;
    if($id >0 ) {
      $sql = "SELECT * FROM userinfo WHERE id=$id;";
      $result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
    } else {
      $result = false;
    }
    return $result;
  }



/* UPDATE */
  function updateUser($id, $username, $password) {
    global $conn;
    $username=mysqli_real_escape_string($conn, $username);
    $password=mysqli_real_escape_string($conn, $password);
    $id = (int)$id;
    
    if ($username and $id) { //if title is not empty
      $sql = "UPDATE `userinfo` SET `username`='$username',`password`='$password' WHERE `id`=$id;";
      // 執行SQL
      mysqli_query($conn, $sql) or die("Insert failed, SQL query error");
    }


/* DELETE */
  function deleteUser($id) {
    global $conn;
    //對$id 做基本檢誤，必須是int值
    $id = (int) $id;
    // 從db刪除傳進來id的資料
    $sql = "DELETE FROM `userinfo` WHERE id=$id;";
    return mysqli_query($conn, $sql); //執行SQL
  }
  
}
?>
