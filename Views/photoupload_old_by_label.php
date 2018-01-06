<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
?>
		<title>讀取圖片Exif信息</title>
	</head>
	<body>
    <div class="container">
      <div class="row">
        <form action="../Modules/upload_exifreader.php" enctype="multipart/form-data" method="post" name="upform">
          <div class="col-12">
            <div class="form-group">
              <label for="uploading">請選擇上傳類別:</label>
              <select class="form-control" id="uploading" name="keyword">
                <option value="frog">青蛙</option>
                <option value="butterfly">蝴蝶</option>
              </select>
            </div>
            <div class="form-group" >
              <!-- <input class="inputbutton" name="keyword" type="text" /> -->
              <input class="form-control" name="exif[]" type="file" multiple="multiple" placeholder="可選擇多檔案上傳"/>
              <br/>
              <input class="btn btn-success" type="submit" value="讀取EXIF" />
            </div>
          </div>
          </form>
      </div>
    </div>
<?php
  include 'footer.php';
?>

<?php
 /* 參考資料
  * http://www.javascripthive.info/php/php-file-uploading/
  * https://blog.longwin.com.tw/2009/01/php-get-directory-file-path-dirname-2008/
  * https://www.inote.tw/php-directory-functions
  * https://stackoverflow.com/questions/18801056/php-image-upload-function-save-in-a-dir-and-then-return-save-image-url
  * https://www.moonlol.com/%E4%B8%8A%E5%82%B3%E5%9C%96%E7%89%87exif%E7%9B%B8%E7%89%87-2548.html 
  */
?>