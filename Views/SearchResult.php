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
  echo "你輸入的值為："."<br/>Keyword: ".$keyword."<br/>label: ".$label."<br/>Family:".$family."<br/>Genus:".$genus;
  echo "<br/><hr/><br/>";
  echo '<hr/><br/><table class="table"><tr>';
    $results=searchEcology($keyword,$label,$family,$genus);
    $count = 0;
    foreach ($results as $key => $section) {
      if($count == 0) {
        foreach ($section as $name => $val) {
          echo "<td>$name</td>";
          $count ++;
        }
      } else if ($count > 0) {
        echo "</tr><tr>";
        foreach ($section as $name => $val) {
          echo "<td>$val</td>";
      }
    }
      echo "</tr>";
  }
  echo '</table>'
  ?>
</div>
<?php
  include 'footer.php'
?>