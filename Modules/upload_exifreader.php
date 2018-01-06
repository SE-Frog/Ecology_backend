<?php
  error_reporting(0);
  require_once('dbConnect.php');
  function createPhotoExif($directory='',$path = '', $name = '', $longitude = NULL, $latitude = NULL,  $shootdatetime = NULL) //儲存資料到資料庫
  {
    // 宣告使用conn全域變數
    global $conn;
    // 判斷名稱是否為空
    if($path == '') {
        return false;
    } else {
        // 過濾字串
        $directory = htmlspecialchars(mysqli_real_escape_string($conn, $directory));
        $path = htmlspecialchars(mysqli_real_escape_string($conn, $path));
        $name = htmlspecialchars(mysqli_real_escape_string($conn, $name));
        $longitude = htmlspecialchars(mysqli_real_escape_string($conn, $longitude));
        $latitude = htmlspecialchars(mysqli_real_escape_string($conn, $latitude));
        $shootdatetime = htmlspecialchars(mysqli_real_escape_string($conn, $shootdatetime));
        // 新增資料
        $sql = "INSERT INTO `photo` (`directory`, `path`, `name`, `longitude`, `latitude`, `shootdatetime`) VALUES ('$directory', '$path', '$name', '$longitude', '$latitude', '$shootdatetime');";
        return mysqli_query($conn, $sql);
    }
  }
  function updateOnlyExif($longitude = NULL, $latitude = NULL, $shootdatetime = NULL) {
    // 宣告使用conn全域變數
    global $conn;
    // 判斷id是否為空
    if($id == NULL) {
        return false;
    } else {
        // 過濾字串
        $id = (int)$id;
        $longitude = htmlspecialchars(mysqli_real_escape_string($conn, $longitude));
        $latitude = htmlspecialchars(mysqli_real_escape_string($conn, $latitude));
        $shootdatetime = htmlspecialchars(mysqli_real_escape_string($conn, $shootdatetime));
        // 新增資料
        $sql = "UPDATE `photo` SET `longitude` = '$longitude', `latitude` = '$latitude', `shootdatetime` = '$shootdatetime'  WHERE `id` = '$id'";
        return mysqli_query($conn, $sql);
    }
  }
  function updatePhotoExif($id,$directory='',$path = '', $name = '', $longitude = NULL, $latitude = NULL,  $shootdatetime = NULL) //儲存資料到資料庫
  {
    // 宣告使用conn全域變數
    global $conn;
    // 判斷名稱或id是否為空
    if($path == '' || $id == NULL) {
        return false;
    } else {
        // 過濾字串
        $id = (int)$id;
        $directory = htmlspecialchars(mysqli_real_escape_string($conn, $directory));
        $path = htmlspecialchars(mysqli_real_escape_string($conn, $path));
        $name = htmlspecialchars(mysqli_real_escape_string($conn, $name));
        $longitude = htmlspecialchars(mysqli_real_escape_string($conn, $longitude));
        $latitude = htmlspecialchars(mysqli_real_escape_string($conn, $latitude));
        $shootdatetime = htmlspecialchars(mysqli_real_escape_string($conn, $shootdatetime));
        // 新增資料
        $sql = "UPDATE `photo` SET `directory` = '$directory', `path` = '$path', `name` = '$name', `longitude` = '$longitude', `latitude` = '$latitude', `shootdatetime` = '$shootdatetime'  WHERE `id` = '$id'";
        return mysqli_query($conn, $sql);
    }
  }
  function readGPSinfoEXIF($image_full_name) //從exif內讀取資料，計算經緯度
  {
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
  // echo '<pre>'.var_export($_POST).'</pre>'; //debug用，目前表單內傳送了什麼
  // echo '<pre>'.var_export($_FILES).'</pre>'; //debug用，目前資料陣列內傳送了什麼
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

  $link_error = "../Views/photoupload.php";
  $link_success = "../Views/photoview.php";
  $overwrite = 1;
  $error = '';
  // 多筆檔案loop執行
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    for ($i = 0;$i < $count;$i++){
      if(!is_uploaded_file($_FILES['exif']['tmp_name'][$i])) //檢查上傳文件是否存在
      {
        $error = "第".$i."個<font color='red'>沒有上載圖像文件！</font>";
      }
      if($max_file_size < $_FILES['exif']['size'][$i]) //檢查文件大小，如果文件大於maxfiles
      {
  			$error = "第".$i."個<font color='red'>文件太大！</font>";
      }
      if(!in_array($_FILES['exif']['type'][$i], $uptypes)) //檢查文件類型
      {
        $error = "第".$i."個<font color='red'>不支援此類型圖像文件！</font>";
      }

      $keyword = $_REQUEST['keyword']; // 從表單撈種類
      if(!file_exists($destination_folder.$keyword)) // 如果未建立這個文件夾，則建立一個
      {
        mkdir($destination_folder.$keyword);
      }
      // $tmp_name=$_FILES['exif']['tmp_name'][$i]; //取得存在緩存區時的檔案名稱
      // $image_size = getimagesize($tmp_name); //取得資料的圖片資訊真理
      // $filetype = trim(strtolower(end    (explode( '.', basename($_FILES['exif']['name'][$i]))))); //取得檔案的extension
      // echo "filetype".$filetype."<br/>";
      // $filename   = substr(trim(strtolower(basename($_FILES['exif']['name'][$i] ))),0,-(strlen($filetype)+1)); //取得檔名
      // echo "filename".$filename."<br/>";
      $destination = $destination_folder."/".$keyword."/".$_FILES['exif']['name'][$i]; //目的地地址：'檔案文件夾/種類/檔案原始名稱'
      if (file_exists($destination) && $overwrite != true) //如果有同名文件，且overwrite為0
      {
        $error = "<font color='red'>同名文件已經存在了！</a>";
      }
      elseif (file_exists($destination) && $overwrite == true) //如果有同名文件，且overwrite為1
      {
        $overwrite_message = "<font color='red'>同名文件存在，但因給予overwrite，因此檔案已經被覆蓋了！</a>";
      }
      if(!move_uploaded_file ($_FILES['exif']['tmp_name'][$i], $destination))  //如果無法移動成功
      {
        $error = "<font color='red'>移動文件出錯！</a>";
      }
      if ($_FILES['exif']['error'][$i] > 0)  //如果error中有顯示異常，則
      {
        $error = "抱歉，檔案上傳過程中出錯了";
      }
      if ($error == '') {
        if ($overwrite_message == ''){
          // echo "<script>alert('您的照片上傳成功！');</script>";
        } else {
          // echo "<script>alert('".$overwrite_message."');</script>";
        }
        $result_exif = exif_read_data($destination);
        $results = readGPSinfoEXIF($destination);
        createPhotoExif(
            $directory = $keyword,
            // $directory = (end(explode( '/', $destination_folder))),
            $path = $destination,
            $name = $_FILES['exif']['name'][$i],
            $longitude = $results[1],
            $latitude = $results[0],
            $shootdatetime = date('Y-m-d h:i:s',$result_exif['FileDateTime'])
          );

          // echo serialize($results);
          // print_r($results);
          // echo "<br/><br/>";
          // $result2 = serialize(exif_read_data($destination));
          // print_r($result_exif);
          // print_r($result);
          // echo '<script language="javascript">'.'window.location.href="'.$link_success.'";'.'</script>';
      } else {
        echo $error;
          echo "<script>alert('".$error."');</script>";
          // echo '<script language="javascript">'.'window.location.href="'.$link_error.'";'.'</script>';
      }
    }
  }
?>