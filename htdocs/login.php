<?php 
$pagetitle="Log In | Cadence";
include "Hydrogen/pgTemplate.php";
?>
<?php if (isset($_SESSION['demo'])) unset($_SESSION['demo']); ?>
<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">

	<?php include "Hydrogen/pgLogin.php"; ?>

    </div>
    <div class="w3-third w3-container">
    </div>
  </div>

</div>
<?php include "Hydrogen/elemNavbar.php"; ?>
<?php include "Hydrogen/elemFooter.php"; ?>
</body></html>




