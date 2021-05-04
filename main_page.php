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
      <div class="info">Welcome <?php echo $_SESSION["username"]?>!</div>
      <?php
      if ($_SESSION["voted"] == 0) {
        echo '<div class="info">You have not voted yet!</div>';?>
        <button class="button" onclick="location.href='vote.php'">Vote</button><?php
      }
      else {
        echo '<div class="info">You have already voted</div>';
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
