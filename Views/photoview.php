<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
?>
	<title>EXIF 信息</title>
	<script type="text/javascript">
		function select_format(){
			var on=document.getElementById('fmt').checked;
			document.getElementById('site').style.display=on?'none':'';
			document.getElementById('sited').style.display=!on?'none':'';
		};
		var flag=false;
		function DrawImage(ImgD){
			var image=new Image();
			image.src=ImgD.src;
			if(image.width>0&&image.height>0){flag=true;
				if(image.width/image.height>=120/80){
					if(image.width>120){
						ImgD.width=120;ImgD.height=(image.height*120)/image.width;
					}else {
						ImgD.width=image.width;
						ImgD.height=image.height;
					};
					ImgD.alt=image.width+"×"+image.height;
				} else {
					if(image.height>80){
					ImgD.height=80;
					ImgD.width=(image.width*80)/image.height;
					} else {
					ImgD.width=image.width;
					ImgD.height=image.height;
					};
				ImgD.alt=image.width+"×"+image.height;
				}
			};
		};
		function FileChange(Value){
			flag=false;
			document.all.uploadimage.width=10;
			document.all.uploadimage.height=10;
			document.all.uploadimage.alt="";
			document.all.uploadimage.src=Value;
		};
	</script>
	<style type="text/css">
		body {
			padding:0;
			margin:0;
		}

		#wrapper {
			width:100%;
			margin:50px auto;
			min-height:400px;
		}

		#image {
			float:left;
		}

		#backder {
			border:1px solid #CCC;
			padding:5px;
			margin-bottom:5px;
		}

		#imageMeta {
			margin:0 0 0 10px;
			float:left;
		}
	</style>

    
  <div class="container">
    
<?php
  // require('../Modules/Function.php');
  require('../Modules/photoFunction.php');
  // $test = "艾氏樹蛙";
  // $result=getFullPhoto();
  $result=randOne();
  // $result=randSpecialOne("馬達加斯加彩蛙");
	// $result=getPhotoDirectory("馬達加斯加彩蛙");
  while (	$rs=mysqli_fetch_array($result)) {
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
          echo " <b>圖片名稱：".$rs['directory']."</b><br/><br/>";
            echo " <b>圖片名稱：".$rs['name']."</b><br/><br/>";
            echo " <b>圖片路徑：".$rs['path']."</b><br/><br/>",
    						  "<b>經度：</b>".$rs['longitude']."<br><br>",
    						  "<b>緯度：</b>".$rs['latitude']."<br><br>",
    						  "<b>拍攝日期：".$rs['shootdatetime']."</b>";
          echo " </div>";
        echo " <br>";
        echo " </div>";
      echo "</div>";
    echo "</div>";
  }
?>
  </div>
<?php
  include 'footer.php';
?>