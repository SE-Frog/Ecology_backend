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
    case 'updateEcology':
    $id = (int) $_REQUEST['id'];

    $Organ=$_REQUEST['$Organ'];
    $Label=$_REQUEST['$Label'];
    $Family=$_REQUEST['$Family'];
    $Genus=$_REQUEST['$Genus'];
    $Food=$_REQUEST['$Food'];
    $Season=$_REQUEST['$Season'];
    $Status=$_REQUEST['$Status'];
    $Habitat=$_REQUEST['$Habitat'];
    $Note=$_REQUEST['$Note'];
    updateBook($Organ,$Label,$Family,$Genus,$Food,$Season,$Status,$Habitat,$Note);
    break;
}
?>
<?php header('Location: ../View/SearchView.php'); ?>