<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
?>
<div class="container">
  <h1>Add User</h1><hr />
  <form method="post" action="../Control/userControl.php">
    <input type="hidden" name="act" value="addUser">
    User Name: <input type="username" name="username"><br />
    Password : <input type="password" name="password"><br />
    <input type="submit">
  </form>
</div>

<?php
  include 'footer.php';
?>
