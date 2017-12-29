<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
  require("../Modules/userModel.php");
?>
<div class = "container">
  <?php
    $results=getUserList();
    while (	$rs=mysqli_fetch_array($results)) {
      echo 
      "<br/><b>id:</b>",$rs['id'],
      "<br/><b>name:</b>",$rs['username'],
      "<br/><b>password:</b>",$rs['password'],
      "<br/><a href='../Control/userControl.php?act=deleteUser&id=",$rs['id'],"'>delete</a>",
      "&nbsp;&nbsp;&nbsp;<a href='../Views/userinfo_edit.php?id=",$rs['id'],"'>edit</a>",
      "&nbsp;&nbsp;&nbsp;<a href='../Views/userinfo_add.php?'>add</a>",
      "<br/>";
    }
  ?>
</div>
<?php
  include 'footer.php'
?>