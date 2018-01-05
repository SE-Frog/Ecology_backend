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