<?php 
if (session_status() == PHP_SESSION_NONE) session_start(); 
require_once 'Hydrogen/libAuthenticate.php';
require_once 'settingsHydrogen.php';
if (isset($_POST['uname']) and isset($_POST['passwd'])) {

	//the credentials are there, so attempt to authenticate
	//using whatever method is defined in libAuthenticate.php
	if (authenticate($_POST['uname'],$_POST['passwd'])==1) {
		$_SESSION['username']=$_POST['uname'];
		//the user is now logged in
		//$_SESSION['password']=$_POST['passwd'];
		//unset($_SESSION['errMsg']);
	}


	if (isset($_SESSION['username']) and isset($_SESSION['referring_page'])) {
			echo '<html><head><meta http-equiv="Refresh" content="0; url=' . $_SESSION['referring_page'] .'" />  </head></html>';
			exit;
	} else {
		echo '<html><head></head><body><p>Username: '. $_SESSION['username']. ' <br> Referring page:' . $_SESSION['referring_page'] . '</p></body></html>';
		exit;
	}
}
$pagetitle="Log In | Cadence";
include "Hydrogen/pgTemplate.php";
$headline = '<h1>Cadence</h1>' ;
?>
<?php if (isset($_SESSION['demo'])) unset($_SESSION['demo']); ?>
<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">
<?php include 'Hydrogen/elemLogoHeadline.php';  ?>
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




