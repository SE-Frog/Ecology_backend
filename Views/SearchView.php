<?php 
  include 'header.php';
  require_once('../Modules/Function.php');
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
?>
<div class="container">
  <?php
    // 引入Seach.php裡面的函式
    // 將return回來的sql資料存入result中
    $result = getFullList();

    // 搜尋的方式, 變數依序為 關鍵字（查詢名字、外觀、習性）、標籤、科別、屬別
    // 如果不拘則不需要傳入變數, 但若是針對後面變數進行篩選, 請在前面變數填 "%"
    // 例如下列範例為: 只要搜尋label(標籤)符合frog的資料, 但是前面還有一個變數"關鍵字"
    // 故需填入"%", 而後面變數沒有使用到則無需填入
    //$result = searchEcology("%", "frog");

    // 資料太多需要分頁的話請用下方函式, 每頁顯示10筆, 並讀取第一頁
    //$result = getPaginationList(10, 1);

    // 判斷是否有資料回傳

    if($result->num_rows === 0) {
      // query資料為空
      echo "Empty";
    } else {
      // 逐列進行動作(顯示)
      while($row = mysqli_fetch_array($result)) {
        // 欄位的值 = $row['{欄位名稱}'], 參考下列範例顯示欄位 id 及 organismname
        echo $row['id'] . " " . $row['organismname'] . "<a href='../Control/Control.php?act=deleteEcology&id=".$row['id']."'>delete</a>&nbsp;&nbsp;&nbsp;"."<a href='../Views/SearchView_edit.php?&id=".$row['id']."'>edit</a><br />";
      }
    }
  ?>
</div>


<?php
  include 'footer.php'
?>