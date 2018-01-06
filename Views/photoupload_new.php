<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
  require("../Modules/loginModel.php");
  require("../Modules/Function.php");
?>
	<title>Selectator Plugin</title>
	<link rel="stylesheet" href="../Views/css/fm.selectator.jquery.css"/>
	<style>
		body {
			font-family: sans-serif;
			margin: 0;
			padding: 0;
		}
		label {
			display: block;
			margin-bottom: 5px;
		}
		#wrapper {
			padding: 15px;
		}
		#select1 {
			width: 250px;
			padding: 7px 10px;
		}
		#select2 {
			padding: 5px;
			width: 350px;
			height: 36px;
		}
		#select3 {
			width: 350px;
			height: 36px;
		}		
		#select4 {
			width: 350px;
			height: 36px;
		}		
		#select5 {
			width: 350px;
			height: 50px;
		}		
		#select6 {
			width: 350px;
			height: 36px;
		}		
		#select7 {
			width: 350px;
			height: 36px;
		}		
	</style>
	<script src="../Views/js/jquery-1.11.0.min.js"></script>
	<script src="../Views/js/fm.selectator.jquery.js"></script>
	<script>
		$(function () {
			var $activate_selectator1 = $('#activate_selectator1');
			$activate_selectator1.click(function () {
				var $select1 = $('#select1');
				if ($select1.data('selectator') === undefined) {
					$select1.selectator({
						labels: {
							search: '請鍵入搜尋關鍵字...'
						}
					});
					$activate_selectator1.val('取消搜尋功能');
				} else {
					$select1.selectator('destroy');
					$activate_selectator1.val('開啟搜尋功能');
				}
			});
			$activate_selectator1.trigger('click');


		});
	</script>
<body>
  <div class="container">
    <div id="wrapper">
  		<label for="select1">
  			請輸入關鍵字:
  		</label>
  		<select id="select1" name="select1">
        <?php
          $result = getFullList();
          if($result->num_rows === 0) {
            echo "Empty";
          } else {
            // 逐列進行動作(顯示)
            while($row = mysqli_fetch_array($result)) {
              echo "<option value=\"".$row['id']."\">".$row['organismname']."</option>";
            }
          }
        ?>
  		</select>
  		<input value="activate selectator" id="activate_selectator1" type="button">
  		<br>
  		<br>

  	</div>
  </div>
	

</body>
</html>