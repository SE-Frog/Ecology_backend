<?php
  include 'header.php';
  require("../Modules/photoFunction.php");
  //set the login mark to empty
  if ( ! isset($_SESSION['uID'])) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
  $photoid = (int)$_REQUEST['id'];
  $result=getPhotoID($photoid);
  if ($rs=mysqli_fetch_assoc($result)) {
    $id = $rs['id'];
    $directory = $rs['directory'];
    $path = $rs['path'];
    $name = $rs['name'];
    $longitude = $rs['longitude'];
    $latitude = $rs['latitude'];
    $shootdatetime = $rs['shootdatetime'];
  } else {
    echo "Your id is wrong!!";
    exit(0);
  }
?>


<div class="container">
<?php
  echo "<div class=\"row\">";
  echo "<div id=\"wrapper\">";
  echo " <div id=image>";
  echo " <div id=backder>";
  echo " <a href=".$rs['path']." target='_blank'><img src=\"".$rs['path']."\" id=\"img\" exif=\"true\" width=".(500)." height=".(500);
  echo " title=\"信息:\r文件名:".$rs['name']."\r上傳時間:".$rs['createtime']."\" border='0'></a>";
  echo " </div>";
  echo " </div>";
  echo " <div id=imageMeta>";
  echo " <div class=exif-data>";
  echo "<form method=\"post\" action=\"../Control/photoControl.php\">";
  echo "<input type=\"hidden\" name=\"act\" value=\"updatePhoto\">";
?>
    <b>圖片編號:</b><input type="text" name='photoid' id='photoid' value="<?php echo $photoid;?>"/><br>
    <b>圖片檔案名稱: </b><input name="directory" type="text" id="directory" value="<?php echo $directory;?>" readonly='readonly'/> <br>
    <b>圖片名稱: </b><input name="name" type="text" id="name" value="<?php echo $name;?>" readonly='readonly'/> <br>
    <b>圖片路徑: </b><input name="path" type="text" id="path" value="<?php echo $path;?>" readonly='readonly'/> <br>
    <b>經度: </b><input name="longitude" type="text" id="longitude" value="<?php echo $longitude;?>" /> <br>
    <b>緯度: </b><input name="latitude" type="text" id="latitude" value="<?php echo $latitude;?>" /> <br>
    <b>拍攝日期: </b><input name="shootdatetime" type="text" id="shootdatetime" value="<?php echo $shootdatetime;?>" /> <br>
    <input type="submit" name="Submit" value="送出" />[<a href='../Views/photoview.php'>返回</a>]
<?php
  echo "</form>";
  echo " </div>";
  echo " <br>";
  echo " </div>";
  echo "</div>";
  echo "</div>";
?>
</div>
<?php   
  include 'footer.php';
?>