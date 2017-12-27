<?php
  session_start();
  require_once('../Modules/Search.php');
  $action =$_REQUEST['act'];

  switch ($action) {
    case 'deleteEcology':
      $id = (int) $_REQUEST['id'];
      if ($id > 0) {
        // // if ($id == $_SESSION['uID']){
        deleteEcology($id);
      }
      break;
}
?>
<?php header('Location: ../View/SearchView.php'); ?>