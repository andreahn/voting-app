<?php
session_start();
$login = $_SESSION["username"];
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-box">
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
    echo "<h2>Choose a candidate</h2>";?>
    <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method ="post">
     <div class="radio-item">
      <input type="radio" name="candidate" id="Joe Biden" value="Joe Biden">
      <label for="Joe Biden">Joe Biden</label>
    </div>
    <div class="radio-item">
      <input type="radio" name="candidate" id="Donald Trump" value="Donald Trump">
      <label for="Donald Trump">Donald Trump</label>
    </div>
      <a>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <input type="submit" value="Place Vote">
      </a>
    </form>
    
    <?php
  }
  else {
    echo "You have already voted";?>
    
    <?php
  }
  ?><br>
    <h2>What will you do?</h2>
    <button class="button" onclick="location.href='main_page.php'">Go back</button>
    <button class="button" onclick="location.href='logout.php'">Logout</button>
  <?php
} else {?>
  <div class="wrong">
    Sorry, you are not a valid user, please login!
  </div>
  <button class="button" onclick="location.href='logout.php'">back</button>
<?php } ?>
<br>
</div>
</body>
</html>
