<?php
session_start();
$login = $_SESSION["username"];
?>

<!DOCTYPE HTML>
<html>
<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $vote = $_POST['candidate'];
  echo "voted for: " . $vote . "<br>";
  if ($_SESSION['voted'] == 0) {
  $_SESSION['voted'] = 1;
  $argument = "./vote ".$login. " \"".$vote."\"";
  exec($argument, $test, $ret);
   }
  
}


if ($_SESSION["connected"] == 1) { ?>
  
  <?php
  if ($_SESSION["voted"] == 0) {
    echo "Choose a candidate";?>
    <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method ="post">
      <input type="radio" name="candidate" id="Joe Biden" value="Joe Biden">Joe Biden<br>
      <input type="radio" name="candidate" id="Donald Trump" value="Donald Trump">Donald Trump<br>
      <input type="submit" value="Place Vote">
    </form>
    
    <?php
  }
  else {
    echo "You have already voted";?>
    
    <?php
  }
  ?><br>
  What will you do?<br>
  <button onclick="location.href='main_page.php'">Go back</button>
  <button onclick="location.href='logout.php'">Logout</button>
  <?php
} else {?>
  Sorry, you are not a valid user, please login!<br>
  <button onclick="location.href='logout.php'">back</button>
<?php } ?>
<br>


</html>
