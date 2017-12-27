<?php
session_start();
require_once('../Modules/userModel.php');
require_once('../Modules/loginModel.php');
$action =$_REQUEST['act'];

switch ($action) {
case 'deleteUser':
$id = (int) $_REQUEST['id'];
	if ($id > 0) {
  // // if ($id == $_SESSION['uID']){
  deleteUser($id);
  }
  header('Location: ../Views/userinfo.php');
	break;
case 'addUser':
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
  addUser($username, $password);
  header('Location: ../Views/userinfo.php');
	break;
case 'updateUser':
	$id = (int) $_REQUEST['id'];
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
  updateUser($id, $title, $msg, $name);
  header('Location: ../Views/userinfo.php');
  break;
}
?>