<?php 
$pagetitle="Home | Cadence";
$headline = '<h1>Cadence</h1>' ;
include "Hydrogen/pgTemplate.php";
?>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

<?php include 'Hydrogen/elemLogoHeadline.php';?>

  <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-black">About this application</h1>
      <p>This is a simple reminder application focused on providing flexible and reliable recurrence for reminders.</p><p>With optional use as a CalDAV client, it will enforce recurrence rules in a heterogenous client ecosystem in which recurrence rules might otherwise be removed or corrupted by other clients sharing the same CalDAV data.</p>

    </div>
    <div class="w3-third w3-container">

    </div>
  </div>
  


<!-- END MAIN -->
</div>

<?php include "Hydrogen/elemNavbar.php"; ?>
<?php include "Hydrogen/elemFooter.php"; ?>
</body></html>

