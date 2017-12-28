<?php
  session_start();
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="stylesheet" href="style.css">
  <!--script src="js/scripts.js"></script-->

    <style>

    </style>

    <script type="text/javascript">
    </script>

</head>

<body>

<header>
  <nav>
    <div class="main-wrapper">
      <ul>
        <li>
          <a href="index.php">Home</a>
        </li>
      </ul>
      <div class="nav-login">
        <?php
          if(isset($_SESSION['u_id'])) {
            echo '<form action="includes/logout.inc.php" method="POST">
              <button type="submit" name="submit">Logout</button>
            </form>';
          } else {
            echo '<form action="includes/login.inc.php" method="POST">
              <input type="text" name="uid" placeholder="Username/e-mail">
              <input type="password" name="pwd" placeholder="password">
              <button type="submit" name="submit" id="login">Login</button>
              </form>
              <a href="signup.php">Sign up</a>';
          }
        ?>   
      </div>
    </div>
  </nav>
</header>
