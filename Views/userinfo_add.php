<?php
include 'header.php';

//require("dbconnect.php");

//set the login mark to empty
$_SESSION['uID'] = 0;
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
