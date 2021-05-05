<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  $retval = 0;
  $_SESSION["connected"] = 0;
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    
    //construct command which will be passed to exec
    $argument = "./login ". $login . " ". $pass;
    
    // call login.c with entered id and password
    exec($argument, $voted, $retval);
    
  }
  ?>
  <div class="content-box">
    <h2>Login</h2>
    <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method ="post">
      <div class="user-box">
        <input type="text" name="login">
        <label>ID</label>
      </div>
      <div class="user-box">
        <input type="password" name="pass">
        <label>Password</label>
      </div>
      <a>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <input type="submit" value="Login">
      </a>
    </form>
    
    <?php
    // check whether login was successful
    // login.c returns 11 if successful, 12 otherwise
    if($retval == 11) {
      echo '<div class="info">Login success!</div>';
      $_SESSION["connected"] = 1;
      $_SESSION["username"] = $login;
      $_SESSION["voted"] = $voted[0];
      header("Location: main_page.php");
    }
    else if ($retval == 12) {
      $_SESSION["connected"] = 0;
      echo '<div class="wrong">'.$voted[0].'</div>';
    }
    ?>
  </div> 
</body>
</html>
