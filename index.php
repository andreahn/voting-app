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
  
  // call login.c here

}
?>

<form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method ="post">
  ID: <input type="text" name="login"><br>
  Password: <input type="password" name="pass"><br>
  <input type="submit" value="Login">
</form>
  

  // check whether login was successful
