<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
?>

<head>
  <title>查詢清單</title>
  <!-- <link href="mycss.css" rel="stylesheet" type="text/css" /> -->
  <!-- <style type="text/css"> 
    table {
      border: 2px solid yellow;
      width:35%;
    }
    th, td{
      border: 2px solid gold;
      font-size:25px;
      font-weight:bold;
      font-family:Arial;
      text-align:right;
      width:50px;
    }
  </style> -->
</head>
<body>
  <div class="container">

    <link rel = "stylesheet" type = "text/css" href = "hk.css">
    <form action="SearchResult.php" method="post">
    <!-- <input type="hidden" name ="act" value ="searchEcology"> -->
    <table class="table">
    <tr><th style="text-align:center", colspan="4">Search UI</th></tr>
    
    <tr>
    <td style="text-align:center">關鍵字</td>
    <td style="text-align:left"><input type="text" name="keyword" placeholder="ex.請輸入關鍵字"/></td>
    </tr>
    <tr>
    <td style="text-align:center">物種</td>
    <td style="text-align:left">
    <select name="label">
    <option value="frog" selected >青蛙</option>
    <option value="lepidoptera" >蝴蝶</option>
    </select>
    </td>
    </tr>
    <tr>
    <td style="text-align:center">科別</td>
    <td style="text-align:left"><input type="text" name="family" placeholder="ex.科別"/></td>
    </tr>
    <tr>
    <td style="text-align:center">屬</td>
    <td style="text-align:left"><input type="text" name="genus" placeholder="ex.屬"/></td>
    </tr>
    <tr><th style="text-align:center", colspan="4"><input type="submit" value="Ok" /></tr>
    
    </table>
  </div>


<?php
  include 'footer.php';
?>
