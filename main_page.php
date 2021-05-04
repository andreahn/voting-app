<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-box">
<?php
if ($_SESSION["connected"] == 1) { ?>
  Welcome <?php echo $_SESSION["username"]?>!<br>
  <?php
  if ($_SESSION["voted"] == 0) {
    echo "You have not voted yet!";?>a
    <button class="button" onclick="location.href='vote.php'">Vote</button><?php
  }
  else {
    echo "You have already voted";
  }
  ?><br>
  <div class="user-box">
  What will you do?<br>
  </div>
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
<body>
</html>
