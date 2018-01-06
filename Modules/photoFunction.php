<?php
    // 將MySQL連線資訊從dbConnect.php載入
    require_once('dbConnect.php');

/* READ */
    /* 獲取全部生態照片庫資訊 */
    function getFullPhoto() {
        // 宣告使用conn全域變數
        global $conn;
        // 選取photo資料表中所有照片資訊
        $sql = "SELECT * FROM `photo`";

        return mysqli_query($conn, $sql);
    }
    /* 隨機選取一筆生態照片庫資訊 */
    function randOne() {
        // 宣告使用conn全域變數
        global $conn;
        // 選取photo資料表中所有照片資訊
        $sql = "SELECT * FROM `photo` ORDER BY RAND() LIMIT 1";

        return mysqli_query($conn, $sql);
    }
    /* 隨機選取一筆特定生物生態照片資訊 */
    function randSpecialOne($directory = '%') {
        // 宣告使用conn全域變數
        global $conn;
        // 字串過濾並新增條件
        if($directory != "%") {
            $directory = "%" . mysqli_real_escape_string($conn, $directory) . "%";
        }
        // 選取photo資料表中所有照片資訊
        $sql = "SELECT * FROM `photo` WHERE (`directory` LIKE '$directory' OR `directory` IS NULL) ORDER BY RAND() LIMIT 1";

        return mysqli_query($conn, $sql);
    }

    /* 獲得指定編號生態照片資訊 */
    function getPhotoID($id) {
        // 宣告使用conn全域變數
        global $conn;
        // 針對id做基本檢誤
        $id = (int)$id;
        // 選取photo資料表指定編號生態照片資訊
        $sql = "SELECT * FROM `photo` WHERE `id` = $id";

        return mysqli_query($conn, $sql);
    }

    /* 獲得指定生物(資料夾)生態照片資訊 */
    function getPhotoDirectory($directory) {
        // 宣告使用conn全域變數
        global $conn;
        // 字串過濾
        $directory = mysqli_real_escape_string($conn, $directory);
        // 選取photo資料表中所有照片資訊
        $sql = "SELECT * FROM `photo` WHERE `directory` = $directory";

        return mysqli_query($conn, $sql);
    }

    /* 獲得目前所有資料夾 (可用於搜尋時的Option顯示) */
    function getDirectory() {
        // 宣告使用conn全域變數
        global $conn;
        // 選取並用標籤進行分群
        $sql = "SELECT `directory` FROM `photo` GROUP BY `directory`";

        return mysqli_query($conn, $sql);
    }

    function searchPhoto($directory = '%', $name = '%') {
        // 宣告使用conn全域變數
        global $conn;
        // 過濾字串, 並針對有值參數進行修改
        if($directory != "%") {
            $directory = "%" . mysqli_real_escape_string($conn, $directory) . "%";
        }
        if($name != "%") {
            $name = "%" . mysqli_real_escape_string($conn, $name) . "%";
        }
        $sql = "SELECT * FROM `photo` WHERE (`directory` LIKE '$directory' OR `directory` IS NULL) AND `name` LIKE '$name'";
    }
/* Update */
    // Using upload_exifreader.php
/* Delete */
    function deletePhotoData($id) {
        // 宣告使用conn全域變數
        global $conn;
        // 針對id做基本檢誤
        $id = (int)$id;
        // 刪除這一筆id的所有資料
        $sql = "DELETE FROM `photo` WHERE `id` = $id;";
        // 執行SQL
        return mysqli_query($conn, $sql);
    }
?>