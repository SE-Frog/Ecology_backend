<?php
    // 啟用session
    session_start();
    // 引入loginModel
    require_once('../Modules/loginModel.php');
    $action =$_REQUEST['act'];

    switch ($action) {
        case 'login':
            // 取得從HTML表單傳來之POST參數
            $userName = $_POST['id'];
            $passWord = $_POST['pwd'];
            
            // 比對密碼
            if ( $id = checkIdentity($userName,$passWord)) {
                //若正確則將userID存在session變數中，作為登入成功之記號，並導回首頁
                $_SESSION['uID'] = $id;
                header('Location: ../Views/index.php');
            } else {
                //print error message
                echo "Invalid Username or Password - Please try again <br />";
                echo '<a href="../Views/loginForm.php">Login again</a> ';
            }
        break;

    }
?>