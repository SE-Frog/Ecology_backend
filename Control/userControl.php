<?php
session_start();
require_once('../Modules/userModel.php');
$action =$_REQUEST['act'];

switch ($action) {
case 'deleteUser':
  $id = (int) $_REQUEST['id'];
  if ($id > 0) {

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
  $id = (int)$_REQUEST['user_id'];
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
  updateUser($id, $username, $password);
  header('Location: ../Views/userinfo.php');
  break;
}
?>