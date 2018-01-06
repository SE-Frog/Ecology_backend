<?php
  // 啟動Session 並回收uID
  session_start();
  unset($_SESSION['uID']);
  // 避免Session 重複使用, 回收後關閉Session
  session_destroy();
  // 在header裡面會重新開啟
  include 'header.php';
?>
<div class="container">
  <h1>Login Form</h1><hr />
  <form method="post" action="../Control/loginControl.php">
    <input type="hidden" name="act" value="login">
    User Name: <input type="text" name="id"><br />
    Password : <input type="password" name="pwd"><br />
    <input type="submit">
  </form>
</div>

<?php
  include 'footer.php';
?>
