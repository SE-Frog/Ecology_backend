<?php
// include 'header.php';
session_start();
//require("dbconnect.php");
// require("../Modules/loginModel.php");
require("../Modules/Function.php");
//set the login mark to empty


$id = (int)$_REQUEST['id'];
$result=getListID($id);
if ($rs=mysqli_fetch_assoc($result)) {
  $Organ=$rs['organismname'];
  $Label=$rs['label'];
  $Family=$rs['family'];
  $Genus=$rs['genus'];
  $Food=$rs['food'];
  $Season=$rs['season'];
  $Status=$rs['status'];
  $Habitat=$rs['habitat'];
  $Note=$rs['note'];
  $edit_id = $rs['id'];
} else {
	echo "Your id is wrong!!";
	exit(0);
}
?>
<b>edit ecology of&nbsp;<?php echo $edit_id;?></b>
<hr/>
<form method="post" action="../Control/Control.php?act=updateEcology">
ID:<input type="text" name="dataid" id="dataid" value="<?php echo $edit_id;?>"/><br/>
Organ:<input type="text" name="organismname" id="organismname" value="<?php echo $Organ;?>"/><br/>
Label:<input type="text" name="label" id="label" value="<?php echo $Label;?>"/><br/>
Family:<input type="text" name="family" id="family" value="<?php echo $Family;?>"/><br/>
Genus:<input type="text" name="genus" id="genus" value="<?php echo $Genus;?>"/><br/>
Food:<input type="text" name="food" id="food" value="<?php echo $Food;?>"/><br/>
Season:<input type="text" name="season" id="season" value="<?php echo $Season;?>"/><br/>
Status:<input type="text" name="status" id="status" value="<?php echo $Status;?>"/><br/>
Habitat:<input type="text" name="habitat" id="habitat" value="<?php echo $Habitat;?>"/><br/>
Note:<input type="text" name="note" id="note" value="<?php echo $Note;?>"/><br/>
<input type="submit" name="Submit" value="送出" />[<a href='../Views/SearchView.php'>返回</a>]
	</form>
<?php   
?>