<?php

/**
 * 單一及多檔案上傳
 *
 * @author  smalljacky <small.jack.computer@gmail.com>
 * @author [Fix and Implement] minecola <wang.minecola@gmail.com>
 * @version 1.0 + 0.5
 */

class Upload
{
    /**
     * DB連線狀態
     *
     * @var object
     */
    private $db;

    /**
     * 檢查檔案是否為更新檔案
     *
     * @var boolean
     */
    private $uploadType;

    /**
     * 檢查檔案是否為更新檔案
     *
     * @var int
     */
    private $id;

    /**
     * 檢查上傳檔案是否為允許的類型
     *
     * @var array
     */
    private $allowMIME;

    /**
     * 允許上傳檔案的擴展名
     *
     * @var array
     */
    private $allowExt;

    /**
     * 上傳檔案容量大小限制
     *
     * @var int
     */
    private $maxSize;

    /**
     * 檢查是否為真實的圖片類型（只允許上傳圖片的話）
     *
     * @var boolean
     */
    private $flag;

    /**
     * 存放檔案的目錄
     *
     * @var string
     */
    private $uploadPath;

    /**
     * $_FILES 取得的 HTTP 檔案上傳項目
     *
     * @var array
     */
    private $fileInfo;

    /**
     * 上傳檔案訊息
     *
     * @var array
     */
    private $res;

    /**
     * 分類/資料夾名稱
     *
     * @var string
     */
    private $directory;

    /**
     * 實際儲存檔名路徑
     *
     * @var array
     */
    private $uploadFiles;

    /**
     * 儲存擴展名
     *
     * @var string
     */
    private $ext;

    /**
     * 檔案限制設定
     *
     * @param  boolean $uploadType
     * @param  int $id
     * @param  string $directory
     * @param  array $allowMIME
     * @param  array $allowExt
     * @param  int $maxSize
     * @param  boolean $flag
     * @param  string $uploadPath
     */
    public function __construct($directory = 'Undefined', $uploadType = false, $id = NULL, array $allowMIME = array('image/jpeg', 'image/png', 'image/gif'), array $allowExt = array('jpeg', 'jpg', 'gif', 'png'), $maxSize = 26214400, $flag = true, $uploadPath = '../Public')
    {
        require_once('dbConnect.php');
        $this->db = $conn;
        $this->fileInfo = $this->getFiles();
        $this->allowMIME = $allowMIME;
        $this->allowExt = $allowExt;
        $this->maxSize = $maxSize;
        $this->flag = $flag;
        $this->directory = $directory;
        $this->uploadPath = $uploadPath . '/' . $directory;
        $this->uploadType = $uploadType;
        if($uploadType == true) {
            $this->$id = $id;
        }
    }

    /**
     * 將實際儲存檔名存入 array
     *
     * @return void
     */
    public function callUploadFile()
    {
        $res = '';

        // 判斷是否為更新檔案
        if(!$this->uploadType) {
            foreach ($this->fileInfo as $file) {
                $res = $this->uploadFile($file);
                $this->showMessage();   // 顯示上傳訊息

                if (!empty($this->res['dest'])) {
                    $this->uploadFiles[] = $res['dest'];
                }

                $this->res = array();  // 清除所有訊息
            }
        } else if($this->id == NULL){
            // 更新檔案時必須給id
            $res['error'] = "無法更新照片 (未提供ID)";
            $this->showMessage();
        } else if(is_string($this->fileInfo['name'])){
            // 單檔案就上傳
            $res = $this->uploadFile($this->fileInfo);
            $this->showMessage();   // 顯示上傳訊息

            if (!empty($this->res['dest'])) {
                $this->uploadFiles[] = $res['dest'];
            }

            $this->res = array();  // 清除所有訊息
        } else {
            // 多檔案拒絕
            $res['error'] = "更新僅能上傳單一檔案";
            $this->showMessage();
        }
    }

    /**
     * 取得實際儲存檔名路徑
     *
     * @return array
     */
    public function getDestination()
    {
        if (!empty($this->uploadFiles)) {
            print_r($this->uploadFiles);
        }
    }

    /**
     * 判斷上傳單一或多個檔案，並重新建構上傳檔案的 array
     *
     * @return array
     */
    protected function getFiles()
    {
        $i = 0;  // 遞增 array 數量

        foreach ($_FILES as $file) {
            // string 型態，表示上傳單一檔案
            if (is_string($file['name'])) {
                $files[$i] = $file;
                $i++;
            } elseif (is_array($file['name'])) {    // array 型態，表示上傳多個檔案
                foreach ($file['name'] as $key => $value) {
                    $files[$i]['name'] = $file['name'][$key];
                    $files[$i]['type'] = $file['type'][$key];
                    $files[$i]['tmp_name'] = $file['tmp_name'][$key];
                    $files[$i]['error'] = $file['error'][$key];
                    $files[$i]['size'] = $file['size'][$key];
                    $i++;
                }
            }
            return $files;
        }
    }

    /**
     * 單一及多檔案上傳，並回傳存放目錄 + md5 產生的檔案名稱 + 擴展名
     *
     * @return array
     */
    private function uploadFile($file)
    {
        require_once('photoFunction.php');

        $uniName = '';
        $destination = '';

        if ($this->checkError($file) && $this->checkHttpPost($file) && $this->checkMIME($file) && $this->checkExt($file) && $this->checkSize($file) && $this->checkTrueImg($file)) {
            $this->checkUploadPath();
            $uniName = $this->getUniName();
            $destination = $this->uploadPath . '/' . $uniName . '.' . $this->ext;

            if (!@move_uploaded_file($file['tmp_name'], $destination)) {
                $this->res['error'] = $file['name'] . '檔案移動失敗';
            } else {
                $this->res['succ'] = $file['name'] . '檔案上傳成功';
                $this->res['dest'] = $destination;
                $result = $this->readGPSinfoEXIF($destination);
                if($this->uploadType == false) {
                    $temp = $this->directory;
                    $this->createPhotoEXIF($temp, $destination, $file['name'], $result[0], $result[1], $result[2]);
                } else {
                    $this->updatePhotoEXIF($this->id, $this->directory, $destination, $result[0], $result[1], $result[2]);
                }
            }
        }
        return $this->res;
    }

    /**
     * 檢查上傳檔案是否有錯誤
     *
     * @param  array $files 透過 $_FILES 取得的 HTTP 檔案上傳的項目 array
     * @return boolean
     */
    protected function checkError($file)
    {
        if ($file['error'] > 0) {
            switch ($file['error']) {
                case 1:
                    $this->res['error'] = $file['name'] . ' 上傳的檔案超過了 php.ini 中 upload_max_filesize 允許上傳檔案容量的最大值';
                    break;
                case 2:
                    $this->res['error'] = $file['name'] . ' 上傳檔案的大小超過了 HTML 表單中 MAX_FILE_SIZE 選項指定的值';
                    break;
                case 3:
                    $this->res['error'] = $file['name'] . ' 檔案只有部分被上傳';
                    break;
                case 4:
                    $this->res['error'] = $file['name'] . ' 沒有檔案被上傳（沒有選擇上傳檔案就送出表單）';
                    break;
                case 6:
                    $this->res['error'] = $file['name'] . ' 找不到臨時目錄';
                    break;
                case 7:
                    $this->res['error'] = $file['name'] . ' 檔案寫入失敗';
                    break;
                case 8:
                    $this->res['error'] = $file['name'] . ' 上傳的文件被 PHP 擴展程式中斷';
                    break;
            }
            return false;
        }
        return true;
    }

    /**
     * 檢查檔案是否是通過 HTTP POST 上傳的
     *
     * @param  array $files 透過 $_FILES 取得的 HTTP 檔案上傳的項目 array
     * @return boolean
     */
    private function checkHttpPost($file)
    {
        if (!is_uploaded_file($file['tmp_name'])) {
            $this->res['error'] = $file['name'] . '檔案不是通過 HTTP POST 方式上傳的';
            return false;
        }
        return true;
    }

    /**
     * 檢查上傳檔案是否為允許的類型
     *
     * @param  array $files 透過 $_FILES 取得的 HTTP 檔案上傳的項目 array
     * @return boolean
     */
    private function checkMIME($file)
    {
        if (!in_array($file['type'], $this->allowMIME)) {
            $this->res['error'] = $file['name'] . '不是允許的檔案類型';
            return false;
        }
        return true;
    }

    /**
     * 檢查上傳檔案是否為允許的擴展名
     *
     * @param  array $files 透過 $_FILES 取得的 HTTP 檔案上傳的項目 array
     * @return boolean
     */
    private function checkExt($file)
    {
        $this->ext = pathinfo($file['name'], PATHINFO_EXTENSION);  // 取得上傳檔案的擴展名

        // 檢查上傳檔案是否為允許的擴展名、及參數是否為陣列
        if (!is_array($this->allowExt)) {
            $this->res['error'] = $file['name'] . ' 檔案類型型態必須為 array';
            return false;
        } else {
            // 檢查陣列中是否有允許的擴展名
            if (!in_array($this->ext, $this->allowExt)) {
                $this->res['error'] = $file['name'] . ' 非法檔案類型';
                return false;
            }
        }
        return true;
    }

    /**
     * 檢查上傳檔案的容量大小是否符合規範
     *
     * @param  array $files 透過 $_FILES 取得的 HTTP 檔案上傳的項目 array
     * @return boolean
     */
    private function checkSize($file)
    {
        if ($file['size'] > $this->maxSize) {
            $this->res['error'] = $file['name'] . '上傳檔案容量超過限制';
            return false;
        }
        return true;
    }

    /**
     * 檢查是否為真實的圖片類型
     *
     * @param  array $files 透過 $_FILES 取得的 HTTP 檔案上傳的項目 array
     * @return boolean
     */
    private function checkTrueImg(array $file)
    {
        if ($this->flag) {
            if (!@getimagesize($file['tmp_name'])) {
                $this->res['error'] = $file['name'] . '不是真正的圖片類型';
                return false;
            }
            return true;
        }
    }

    /**
     * 檢查指定目錄是否存在，不存在就建立目錄
     *
     * @return void
     */
    private function checkUploadPath()
    {
        if (!file_exists($this->uploadPath)) {
          $str = $this->uploadPath;
          $str = mb_convert_encoding($str, "utf-8", "auto");
          mkdir($str, 0777, true);
          // mkdir($this->uploadPath, 0777, true); //如有問題，請註解以上3行，解除註解這行
          
        }
    }

    /**
     * 產生唯一的檔案名稱
     *
     * @return string
     */
    private function getUniName()
    {
        return md5(uniqid(microtime(true), true));
    }

    /**
     * 新增一筆圖片
     *
     * @return object
     */
    private function createPhotoEXIF($directory = '', $path = '', $name = '', $longitude = NULL, $latitude = NULL,  $shootdatetime = NULL) {
        if($directory == '' || $path == '' || $name == '') {
            return false;
        } else {
            // 過濾字串
            $directory = htmlspecialchars(mysqli_real_escape_string($this->db, $directory));
            $path = htmlspecialchars(mysqli_real_escape_string($this->db, $path));
            $name = htmlspecialchars(mysqli_real_escape_string($this->db, $name));
            if($longitude != NULL) {
                $longitude = htmlspecialchars(mysqli_real_escape_string($this->db, $longitude));
            }
            if($latitude != NULL) {
                $latitude = htmlspecialchars(mysqli_real_escape_string($this->db, $latitude));
            }
            $shootdatetime = htmlspecialchars(mysqli_real_escape_string($this->db, $shootdatetime));
            // 新增資料
            $sql = "INSERT INTO `photo` (`directory`, `path`, `name`, `longitude`, `latitude`, `shootdatetime`) VALUES ('$directory', '$path', '$name','$longitude', '$latitude', '$shootdatetime')";

            mysqli_query($this->db, $sql);
        }
    }

    /**
     * 更新圖片與EXIF
     *
     * @return object
     */
    private function updatePhotoEXIF($id = NULL, $directory = '', $path = '', $name = '', $longitude = NULL, $latitude = NULL, $shootdatetime = NULL) {
        // 判斷檔案資訊或id不得為空
        if($id == NULL || $directory == '' || $path == '' || $name == '') {
            return false;
        } else {
            // 過濾字串
            $id = (int)$id;
            $directory = htmlspecialchars(mysqli_real_escape_string($this->db, $directory));
            $path = htmlspecialchars(mysqli_real_escape_string($this->db, $path));
            $name = htmlspecialchars(mysqli_real_escape_string($this->db, $name));
            if($longitude != NULL) {
                $longitude = htmlspecialchars(mysqli_real_escape_string($this->db, $longitude));
            }
            if($latitude != NULL) {
                $latitude = htmlspecialchars(mysqli_real_escape_string($this->db, $latitude));
            }
            $shootdatetime = htmlspecialchars(mysqli_real_escape_string($this->db, $shootdatetime));
            // 新增資料
            $sql = "UPDATE `photo` SET `directory` = '$directory', `path` = '$path', `name` = '$name', `longitude` = '$longitude', `latitude` = '$latitude', `shootdatetime` = '$shootdatetime'  WHERE `id` = '$id'";

            mysqli_query($this->db, $sql);
        }
    }

    /**
     * 讀取exif
     *
     * @return array
     */
    private function readGPSinfoEXIF($imageFile) {
        if (!in_array(exif_imagetype($imageFile), array(IMAGETYPE_JPEG, IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM))) {
            return array(NULL, NULL, NULL);
        }
        $exif = exif_read_data($imageFile, 0, true);
        /* 如果圖檔無法讀取exif，或exif內沒有GPS經緯度 */
        if(!$exif || empty($exif['GPS'])) {
            return array(NULL, NULL, NULL);
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
            $gps_int = array($lon_s+ $lon_m / 60.0 + $lon_v / 3600.0, $lat_s + $lat_m / 60.0 + $lat_v / 3600.0, $exif['FILE']['FileDateTime']);
            return $gps_int;
        }
    }

    /**
     * 顯示上傳訊息
     *
     * @return void
     */
    private function showMessage()
    {
        if (!empty($this->res['error'])) {
            echo '<span style="color: #ff0000;">' . $this->res['error'] . '</span><br>';
        } else {
            echo '<span style="color: #0000ff;">' . $this->res['succ'] . '</span><br>';
        }
    }
}
