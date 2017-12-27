<?php
include 'header.php';
//require("dbconnect.php");
// require("../Modules/loginModel.php");
require("../Modules/userModel.php");
//set the login mark to empty
if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
	header("Location: ../Views/loginForm.php");
	exit(0);
}

$id = (int)$_REQUEST['id'];
$result=getListID($id);
if ($rs=mysqli_fetch_assoc($result)) {
  $Organ=$rs['$Organ'];
  $Label=$rs['$Label'];
  $Family=$rs['$Family'];
  $Genus=$rs['$Genus'];
  $Food=$rs['$Food'];
  $Season=$rs['$Season'];
  $Status=$rs['$Status'];
  $Habitat=$rs['$Habitat'];
  $Note=$rs['$Note'];
  $id = $rs['id'];
} else {
	echo "Your id is wrong!!";
	exit(0);
}
?>
<b>edit userinfo of&nbsp;<?php echo $username;?></b>
<hr/>
<form method="post" action="../Control/SearchControl.php?act=updateEcology">
ID:<input type="text" name='id' disabled='disabled' value="<?php echo $id;?> "/><br>
Organ:<input type="text" name="Organ" id="Organ" value="<?php echo $Organ;?>"/><br/>
Label:<input type="text" name="Label" id="Label" value="<?php echo $Label;?>"/><br/>
Family:<input type="text" name="Family" id="Family" value="<?php echo $Family;?>"/><br/>
Genus:<input type="text" name="Genus" id="Genus" value="<?php echo $Genus;?>"/><br/>
Food:<input type="text" name="Food" id="Food" value="<?php echo $Food;?>"/><br/>
Season:<input type="text" name="Season" id="Season" value="<?php echo $Season;?>"/><br/>
Status:<input type="text" name="Status" id="Status" value="<?php echo $Status;?>"/><br/>
Habitat:<input type="text" name="Habitat" id="Habitat" value="<?php echo $Habitat;?>"/><br/>
Note:<input type="text" name="Note" id="Note" value="<?php echo $Note;?>"/><br/>
<input type="submit" name="Submit" value="送出" />[<a href='../Views/SearchView.php'>返回</a>]
	</form>
<?php   
?>