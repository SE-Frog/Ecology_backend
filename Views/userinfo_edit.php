<?php
include 'header.php';
//require("dbconnect.php");
// require("../Modules/loginModel.php");
require("../Modules/userModel.php");
//set the login mark to empty
if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
	header("Location: ../Views/loginForm.php");
	exit(0);
}

$userid = (int)$_REQUEST['id'];
$result=userDetails($userid);
if ($rs=mysqli_fetch_assoc($result)) {
	$username = $rs['username'];
	$password=$rs['password'];
  $id = $rs['id'];
} else {
	echo "Your id is wrong!!";
	exit(0);
}
?>
<b>edit userinfo of&nbsp;<?php echo $username;?></b>
<hr/>
<form method="post" action="../Control/userControl.php?act=updateUser">
ID:<input type="text" name='id' disabled='disabled' value="<?php echo $id;?> "/><br>
Name: <input name="title" type="text" id="title" value="<?php echo $username;?>" /> <br>
Password: <input name="msg" type="text" id="msg" value="<?php echo $password;?>" /> <br>
<input type="submit" name="Submit" value="送出" />[<a href='../Views/userinfo.php'>返回</a>]
	</form>
<?php   
?>