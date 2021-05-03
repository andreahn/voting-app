<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<?php
if ($_SESSION["connected"] == 1) { ?>
  Welcome <?php echo $_SESSION["username"]?>!<br>
  <?php
  if ($_SESSION["voted"] == 0) {
    echo "You have not voted yet!";?>a
    <button onclick="location.href='vote.php'">Vote</button><?php
  }
  else {
    echo "You have already voted";
  }
  ?><br>
  What will you do?<br>
  <button onclick="location.href='logout.php'">Logout</button>
  <?php
} else {?>
  Sorry, you are not a valid user, please login!<br>
  <button onclick="location.href='logout.php'">back</button>
<?php } ?>
<br>


</html>
