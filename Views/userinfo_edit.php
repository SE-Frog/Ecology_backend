<?php
  include 'header.php';
  require("../Modules/userModel.php");
  //set the login mark to empty
  if ( ! isset($_SESSION['uID'])) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
  $userid = (int)$_REQUEST['id'];
  $result=userDetails($userid);
  if ($rs=mysqli_fetch_assoc($result)) {
    $username = $rs['username'];
    $password=$rs['password'];
    $user_id = $rs['id'];
  } else {
    echo "Your id is wrong!!";
    exit(0);
  }
?>
<div class="container">
  <b>edit userinfo of&nbsp;<?php echo $username;?></b>
  <hr/>
  <form method="post" action="../Control/userControl.php">
    <input type="hidden" name="act" value="updateUser">
    <b>ID:</b><input type="text" name='user_id' id='user_id' value="<?php echo $user_id;?>"/><br>
    <b>Name: </b><input name="username" type="text" id="username" value="<?php echo $username;?>" /> <br>
    <b>Password: </b><input name="password" type="text" id="password" value="<?php echo $password;?>" /> <br>
    <input type="submit" name="Submit" value="送出" />[<a href='../Views/userinfo.php'>返回</a>]
  </form>
</div>
<?php   
  include 'footer.php';
?>