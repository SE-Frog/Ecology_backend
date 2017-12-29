<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
?>
<div class="container">
<h1>登錄成功！</h1>
<h2>這是主頁</h2>
</div>

