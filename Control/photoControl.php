<?php
    session_start();
    // require_once('../Modules/photoFunction.php');
    require_once('../Modules/upload_exifreader.php');
    $action =$_REQUEST['act'];

    switch ($action) {
        case 'updatePhoto':
            $id = (int) $_REQUEST['photoid'];
            if ($id > 0) {
              updatePhotoExif($id,$_REQUEST['directory'], $_REQUEST['path'],$_REQUEST['name'], $_REQUEST['longitude'], $_REQUEST['latitude'], $_REQUEST['shootdatetime']);
            }
            // echo "id".$id,"<br/>directory".$_REQUEST['directory']."<br/>path".$_REQUEST['path']."<br/>name".$_REQUEST['name']."<br/>longtitude". $_REQUEST['longitude']."<br/>latitude".$_REQUEST['latitude']."<br/>shootdatetime".$_REQUEST['shootdatetime'];
            header('Location: ../Views/photoview.php');
            break;
    }
?>