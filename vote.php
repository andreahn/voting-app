<?php
session_start();
$login = $_SESSION["username"];
$pass = $_SESSION["pass"];
?>

<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="content-box">
    <?php
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      $vote = $_POST['candidate'];
      echo '<div class="info">Voted for: ' . $vote . '</div>';
      if ($_SESSION['voted'] == 0) {
        $_SESSION['voted'] = 1;
        $login = preg_replace('/[^A-Za-z0-9 ]/', '', $login);
        $vote = preg_replace('/[^A-Za-z0-9 ]/', '', $vote);
        $argument = "./vote ".$login." ".$pass." \"".$vote."\"";
        exec($argument, $test, $ret);
      }
      
    }
    
    
    if ($_SESSION["connected"] == 1) { ?>
      
      <?php
      if ($_SESSION["voted"] == 0) {
        // allow user to place vote
        
        echo "<h2>Choose a candidate</h2>";?>
        <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method ="post">
          <div class="radio-item">
            <input type="radio" name="candidate" id="Jerry Lang" value="Jerry Lang">
            <label for="Jerry Lang">Jerry Lang</label>
          </div>
          <div class="radio-item">
            <input type="radio" name="candidate" id="Elleanor Klein" value="Elleanor Klein">
            <label for="Elleanor Klein">Elleanor Klein</label>
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
        // user cannot vote
        echo '<div class="info">You have already voted</div>';?>
        
        <?php
      }
      ?><br>
      What will you do?<br>
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
