<?php
  include_once 'header.php';
?>
<section class="main-container">
  <div class="main-wrapper">
    <h2>
      Home
    </h2>
      <?php
        if (isset($_SESSION['u_id'])){
          echo "You are Loged in!<br>";
	  echo"<a href='view.php'>View Offices</a>";
        }
      ?>
  </div>
</section>
<?php
  include_once 'footer.php';
?>
