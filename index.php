<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
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

<form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method ="post">
  ID: <input type="text" name="login"><br>
  Password: <input type="password" name="pass"><br>
  <input type="submit" value="Login">
</form>
  
  <?php
  // check whether login was successful
  // login.c returns 11 if successful, 12 otherwise
if($retval == 11) {
  echo "login success!\n";
  $_SESSION["connected"] = 1;
  $_SESSION["username"] = $login;
  $_SESSION["voted"] = $voted[0];
  header("Location: main_page.php");
}
else if ($retval == 12) {
  $_SESSION["connected"] = 0;
  echo "Incorrect id and password\n";
}
?>
