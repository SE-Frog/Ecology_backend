<?php
require("dbconnect.php"); 
//匯入連結資料庫之共用程式碼

function checkIdentity($userName,$passWord) {
  global $conn;
  $userName = mysqli_real_escape_string($conn,$userName); //將特殊SQL字元編碼，以免被SQL Injection
  $sql = "SELECT password, username FROM `userinfo` WHERE username='$userName'"; //產生SQL指令
  if ($result = mysqli_query($conn,$sql)) { //執行SQL查詢
    if ($row=mysqli_fetch_assoc($result)) { //取得第一筆資料
      if ($row['password'] == $passWord) { //比對密碼
        return true;
      } else {
        return 0;
			}
		} else {
				return 0;
		}
	} else{
		return 0;
	}
}
?>
