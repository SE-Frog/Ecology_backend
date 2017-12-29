<?php
  include 'header.php';
  if ( ! isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
    header("Location: ../Views/loginForm.php");
    exit(0);
  }
  // require("../Modules/loginModel.php");
  require("../Modules/Function.php");
?>
<div class = "container">
  <?php
  $keyword = $_REQUEST['keyword'];
  $label = $_REQUEST['label'];
  $family = $_REQUEST['family'];
  $genus = $_REQUEST['genus'];
  echo "目前收到的值：<br/>"."<br/>Keyword: ".$keyword."<br/>label: ".$label."<br/>Family:".$family."<br/>Genus:".$genus;
  echo "<br/><br/><br/><br/><br/>";
    $results=searchEcology($keyword,$label,$family,$genus);
    foreach ($results as $key => $section) {
      foreach ($section as $name => $val) {
          echo "$key.$name: $val<br />\n";
      }
  }
  ?>
</div>
<?php
  include 'footer.php'
?>