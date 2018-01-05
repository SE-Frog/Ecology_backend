<?php
error_reporting(0);
require_once('dbConnect.php');
function createPhotoExif($userid = '', $recordid = '', $path = '', $name = '', $longitude = NULL, $latitude = NULL,  $shootdatetime = NULL) {
    // 宣告使用conn全域變數
    global $conn;
    // 判斷名稱是否為空
    if($path == '') {
        return false;
    } else {
        // 過濾字串
        $userid = mysqli_real_escape_string($conn, $userid);
        $recordid = mysqli_real_escape_string($conn, $recordid);
        $path = mysqli_real_escape_string($conn, $path);
        $name = mysqli_real_escape_string($conn, $name);
        $longitude = mysqli_real_escape_string($conn, $longitude);
        $latitude = mysqli_real_escape_string($conn, $latitude);
        $shootdatetime = mysqli_real_escape_string($conn, $shootdatetime);
        // 新增資料
        $sql = "INSERT INTO `photo` (`userid`, `recordid`, `path`, `name`, `longitude`, `latitude`, `shootdatetime`) VALUES ('$userid', '$recordid', '$path', '$name', '$longitude', '$latitude', '$shootdatetime');";
        return mysqli_query($conn, $sql);
    }
}
function readGPSinfoEXIF($image_full_name){
  $exif=exif_read_data($image_full_name, 0, true);
  /* 如果圖檔無法讀取exif，或exif內沒有GPS經緯度 */
  if(!$exif || $exif['GPS']['GPSLatitude'] == '') {
    return false;
  } else {
  $lat_ref = $exif['GPS']['GPSLatitudeRef'];
  $lat = $exif['GPS']['GPSLatitude'];
  list($num, $dec) = explode('/', $lat[0]);
  $lat_s = $num / $dec;
  list($num, $dec) = explode('/', $lat[1]);
  $lat_m = $num / $dec;
  list($num, $dec) = explode('/', $lat[2]);
  $lat_v = $num / $dec;

  $lon_ref = $exif['GPS']['GPSLongitudeRef'];
  $lon = $exif['GPS']['GPSLongitude'];
  list($num, $dec) = explode('/', $lon[0]);
  $lon_s = $num / $dec;
  list($num, $dec) = explode('/', $lon[1]);
  $lon_m = $num / $dec;
  list($num, $dec) = explode('/', $lon[2]);
  $lon_v = $num / $dec;

  $gps_int = array($lat_s + $lat_m / 60.0 + $lat_v / 3600.0, $lon_s
          + $lon_m / 60.0 + $lon_v / 3600.0,$exif['FILE']['MimeType'],$exif['FILE']['FileDateTime']);
  return $gps_int;
  }
}
// 計算上傳的資料有多少筆
$count = count($_FILES['exif']['name']); 
  // //debug用，目前表單內傳送了什麼
  // echo '<pre>';
  // var_export($_POST);
  // echo '</pre>';
  // //debug用，目前資料陣列內傳送了什麼
  // echo '<pre>';
  // var_export($_FILES);
  // echo '</pre>';
  $uptypes=array //上傳文件類型列表
    (
      'image/jpg',  
      'image/jpeg',
      'image/png',
      'image/pjpeg'
    );
  $max_file_size=100000000;   //上傳文件大小限制, 單位為BYTE
  $path_parts=pathinfo($_SERVER['PHP_SELF']); //取得當前路徑
  $destination_folder="../Public/"; //上傳文件路徑
  $form_link = "/1061_SE/Views/photoupload.php";
  $imgpreview=1;   //是否生成預覽圖(1為生成,0為不生成);
  $imgpreviewsize=1/1;  //縮略圖比例
  $overwrite = 1;

$error = '';
// 多筆檔案loop執行
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  for ($i = 0;$i < $count;$i++){
    //檢查上傳文件是否存在
    if(!is_uploaded_file($_FILES['exif']['tmp_name'][$i])) {
      $error = "第".$i."個<font color='red'>沒有上載圖像文件！</font>";
    }
    //檢查文件大小，如果文件大於maxfiles
		if($max_file_size < $_FILES['exif']['size'][$i]){
			$error = "第".$i."個<font color='red'>文件太大！</font>";
    }
    //檢查文件類型
    if(!in_array($_FILES['exif']['type'][$i], $uptypes)){
      $error = "第".$i."個<font color='red'>不支援此類型圖像文件！</font>";
    }
    // 如果未建立這個文件夾，則建立一個
    $keyword = $_REQUEST['keyword'];
    if(!file_exists($destination_folder.$keyword)){
      mkdir($destination_folder.$keyword);
    }
    // $tmp_name=$_FILES['exif']['tmp_name'][$i];
    // $image_size = getimagesize($tmp_name);
    // $filetype = trim(strtolower(end    (explode( '.', basename($_FILES['exif']['name'][$i])))));
    // $filename   = substr(trim(strtolower(basename($_FILES['exif']['name'][$i] ))),0,-(strlen($filetype)+1));
    // echo "filename".$filename."<br/>";
    // echo "filetype".$filetype."<br/>";
    $destination = $destination_folder."/".$keyword."/".$_FILES['exif']['name'][$i];
    if (file_exists($destination) && $overwrite != true){
      $error = "<font color='red'>同名文件已經存在了！</a>";
    }
    elseif (file_exists($destination) && $overwrite == true){
      $overwrite_message = "<font color='red'>同名文件已經被覆蓋了！</a>";
    }
    if(!move_uploaded_file ($_FILES['exif']['tmp_name'][$i], $destination)) {
      $error = "<font color='red'>移動文件出錯！</a>";
    }
    if ($_FILES['exif']['error'][$i] > 0) {
      //如果error中有顯示異常，則
      $error = 'Sorry, there was an error in uploading the file';
    }
    // else {
    //     $sizeInfo = getimagesize($_FILES['exif']['tmp_name'][$i]);
    //     if ($sizeInfo[0] > 100 || $sizeInfo[1] > 125) {
    //         $error = 'Image dimensions should be within 100*125';
    //     } else {
    //         move_uploaded_file($_FILES['exif']['tmp_name'][$i], "photos/".$_POST['txtUsername'].".gif");
    //     }
    
    // }
    
    if ($error == '') {
      if ($overwrite_message == ''){
        echo "<script>alert('您的照片上傳成功！');</script>";
        // echo '<a href="'.$destination.'">here</a><br/>';
      } else {
        echo "<script>alert('".$overwrite_message."');</script>";
        // echo $overwrite_message;
        // echo '<a href="'.$destination.'">here</a><br/>';
      }
      $results = readGPSinfoEXIF($destination);
      $result_exif = exif_read_data($destination);

      createPhotoExif(
          $userid ='0',
          $recordid = '0',
          $path = $destination,
          $name = $result_exif['FileName'],
          $longitude = $results[1],
          $latitude = $results[0],
          $shootdatetime = date('Y-m-d h:i:s',$result_exif['FileDateTime'])
        );
        
        // echo serialize($results);
        // print_r($results);
        // echo "<br/><br/>";
        
        // $result2 = serialize(exif_read_data($destination));
        // print_r($result2);
        // print_r(exif_read_data($destination));
        header('Location: ../Views/photoview.php');
    } else {
        echo "<script>alert('".$error."');</script>";
        // echo $error;
        // echo '<br/><a href="'.$form_link.'">按此返回</a><br/>';
        header('Location: ../Views/photoupload.php');
    }
  }
}
?>