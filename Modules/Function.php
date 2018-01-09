<?php
    // 將MySQL連線資訊從dbConnect.php載入
    require_once('dbConnect.php');

/* READ */
    function getPhotoExif() {
      // 宣告使用conn全域變數
      global $conn;
      // 選取photo資料表中所有資料
      $sql = "SELECT * FROM `photo`";

      return mysqli_query($conn, $sql);
    }
    /* 獲取全部生態資料庫資訊 */
    function getFullList() {
        // 宣告使用conn全域變數
        global $conn;
        // 選取library資料表中所有資料
        $sql = "SELECT * FROM `library`";

        return mysqli_query($conn, $sql);
    }

    /* 獲取全部生態資料庫資訊 */
    function getFullListByLabel($label) {
      // 宣告使用conn全域變數
      global $conn;
      // 選取library資料表中所有資料對應label的
      $sql = "SELECT * FROM `library` WHERE `label` = '$label'";

      return mysqli_query($conn, $sql);
    }

    /* 獲得指定編號生態資料 */
    function getListID($id) {
        // 宣告使用conn全域變數
        global $conn;
        // 針對id做基本檢誤
        $id = (int)$id;
        // 選取library資料表中所有資料
        $sql = "SELECT * FROM `library` WHERE `id` = $id";

        return mysqli_query($conn, $sql);
    }

    /* 獲得指定單頁筆數及特定頁數的生態資訊 (一頁顯示多少筆 及 第幾頁) */
    function getPaginationList($SinglePageRow = 10, $Page = 1) {
        // 宣告使用conn全域變數
        global $conn;
        // 強制轉換為數字 (避免被SQL injection)
        $SinglePageRow = (int)$SinglePageRow;
        $Page = (int)$Page;
        // 計算從第幾筆資料開始取
        $start = ($Page - 1) * $SinglePageRow;
        // 選取library資料表中自第 start 筆往後 SinglePageRow(一頁有多少筆) 筆資料
        $sql = "SELECT * FROM `library` LIMIT $start, $SinglePageRow";

        return mysqli_query($conn, $sql);
    }

    /* 獲得目前所有標籤 (可用於搜尋時的Option顯示) */
    function getLabel() {
        // 宣告使用conn全域變數
        global $conn;
        // 選取並用標籤進行分群
        $sql = "SELECT `label` FROM `library` GROUP BY `label`";

        return mysqli_query($conn, $sql);
    }

    /* 獲得目前所有科別 (可用於搜尋時的Option設定) */
    function getFamily() {
        // 宣告使用conn全域變數
        global $conn;
        // 選取並用科別進行分群
        $sql = "SELECT `family` FROM `library` GROUP BY `family`";

        return mysqli_query($conn, $sql);
    }

    /* 獲得目前所有屬 (可用於搜尋時的Option設定) */
    function getGenus() {
        // 宣告使用conn全域變數
        global $conn;
        // 選取並用屬別進行分群
        $sql = "SELECT `genus` FROM `library` GROUP BY `genus`";

        return mysqli_query($conn, $sql);
    }

    /* 搜尋 */
    function searchEcology($Keyword = "%", $Label = "%", $Family = "%", $Genus = "%") {
        // 宣告使用conn全域變數
        global $conn;
        // 過濾字串, 並針對有值參數進行修改
        if($Keyword != "%") {
            $Keyword = "%" . mysqli_real_escape_string($conn, $Keyword) . "%";
        }
        if($Label != "%") {
            $Label = "%" . mysqli_real_escape_string($conn, $Label) . "%";
        }
        if($Family != "%") {
            $Family = "%" . mysqli_real_escape_string($conn, $Family) . "%";
        }
        if($Genus != "%") {
            $Genus = "%" . mysqli_real_escape_string($conn, $Genus) . "%";
        }
        // 選取並用屬別進行分群
        $sql = "SELECT * FROM `library` WHERE `label` LIKE '$Label' AND `family` LIKE '$Family' AND  (`genus` LIKE '$Genus' OR `genus` IS NULL) AND ((`organismname` LIKE '$Keyword' OR `organismname` IS NULL) AND ((`food` LIKE '$Keyword' OR `food` IS NULL) OR (`season` LIKE '$Keyword' OR `season` IS NULL) OR (`status` LIKE '$Keyword' OR `status` IS NULL) OR (`habitat` LIKE '$Keyword' OR `habitat` IS NULL)))";

        return mysqli_query($conn, $sql);
    }

/* CREATE */
    /* 建立一筆新的生態資料 */
    function createEcology($Organ = '', $Label = NULL, $Family = NULL, $Genus = NULL, $Food = NULL, $Season = NULL, $Status = NULL, $Habitat = NULL, $Note = NULL) {
        // 宣告使用conn全域變數
        global $conn;
        // 判斷名稱是否為空
        if($Organ == '') {
            return false;
        } else {
            // 過濾字串
            $Organ = htmlspecialchars(mysqli_real_escape_string($conn, $Organ));
            $Label = htmlspecialchars(mysqli_real_escape_string($conn, $Label));
            $Family = htmlspecialchars(mysqli_real_escape_string($conn, $Family));
            $Genus = htmlspecialchars(mysqli_real_escape_string($conn, $Genus));
            $Food = htmlspecialchars(mysqli_real_escape_string($conn, $Food));
            $Season = htmlspecialchars(mysqli_real_escape_string($conn, $Season));
            $Status = htmlspecialchars(mysqli_real_escape_string($conn, $Status));
            $Habitat = htmlspecialchars(mysqli_real_escape_string($conn, $Habitat));
            $Note = htmlspecialchars(mysqli_real_escape_string($conn, $Note));
            // 新增資料
            $sql = "INSERT INTO `library` (`organismname`, `label`, `family`, `genus`, `food`, `season`, `status`, `habitat`, `note`) VALUES ('$Organ', '$Label', '$Family', '$Genus', '$Food', '$Season', '$Status', '$Habitat', '$Note')";

            return mysqli_query($conn, $sql);
        }
    }
/* UPDATE */
    function updateEcology($id,$Organ, $Label = NULL, $Family = NULL, $Genus = NULL, $Food = NULL, $Season = NULL, $Status = NULL, $Habitat = NULL, $Note = NULL) {
        global $conn;

        $id = (int)$id;
        $Organ = htmlspecialchars(mysqli_real_escape_string($conn, $Organ));
        $Label = htmlspecialchars(mysqli_real_escape_string($conn, $Label));
        $Family = htmlspecialchars(mysqli_real_escape_string($conn, $Family));
        $Genus = htmlspecialchars(mysqli_real_escape_string($conn, $Genus));
        $Food = htmlspecialchars(mysqli_real_escape_string($conn, $Food));
        $Season = htmlspecialchars(mysqli_real_escape_string($conn, $Season));
        $Status = htmlspecialchars(mysqli_real_escape_string($conn, $Status));
        $Habitat = htmlspecialchars(mysqli_real_escape_string($conn, $Habitat));
        $Note = htmlspecialchars(mysqli_real_escape_string($conn, $Note));

        // 生物名稱及編號不得為空
        if (!empty($Organ) && !empty($id)) {

            $sql = "UPDATE `library` SET `organismname`='$Organ',`label`='$Label',`family`='$Family',`genus`='$Genus',`food`='$Food',`season`='$Season',`status`='$Status',`habitat`='$Habitat',`note`='$Note' where `id`=$id;";
            // 執行SQL
            mysqli_query($conn, $sql) or die("Insert failed, SQL query error");
      }
    }
/* DELETE */
    /* 針對ID刪除一筆生態資料 */
    function deleteEcology($id) {
        global $conn;
        // 對id做基本檢誤
        $id = (int)$id;
        // 刪除這一筆id的所有資料
        $sql = "DELETE FROM `library` WHERE `id` = $id;";
        // 執行SQL
        return mysqli_query($conn, $sql);
    }
?>