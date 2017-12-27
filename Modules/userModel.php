<?php
$SuID = $_SESSION['uID'];
require("dbconnect.php");

function getUserList() {
  global $conn;
  // 從資料庫抓取所有user的資料，並依ID順序排列
	$sql = "select * from userinfo order by id ASC";
	return mysqli_query($conn, $sql);
}

function deleteUser($id) {
	global $conn;
	//對$id 做基本檢誤，必須是int值
	$id = (int) $id;
	// 從db刪除傳進來id的資料
	$sql = "delete from userinfo where id=$id;";
	return mysqli_query($conn, $sql); //執行SQL
}


function userDetails($id) {
  global $conn;
  if($id >0 ) {
    $sql = "select * from userinfo where id=$id;";
    $result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
  } else {
    $result = false;
  }
  return $result;
}

function addUser($username='', $password='') {
	global $conn;
	if ($username > ' ') {
		//基本安全處理
		$username=mysqli_real_escape_string($conn, $username);
		$password=mysqli_real_escape_string($conn, $password);
		
		//Generate SQL
		$sql = "insert into userinfo (username, password) values ('$username', '$password');";
		return mysqli_query($conn, $sql); //執行SQL
  } else {
    return false;
  }
}

function updateUser($id, $username, $password) {
	global $conn;
	$username=mysqli_real_escape_string($conn, $user);
  $password=mysqli_real_escape_string($conn, $password);
	$id = (int)$id;

	if ($username and $id) { //if title is not empty
		$sql = "update userinfo set username='$username', password='$password', where id='$id';";
		mysqli_query($conn, $sql) or die("Insert failed, SQL query error"); //執行SQL
	}
}
?>
