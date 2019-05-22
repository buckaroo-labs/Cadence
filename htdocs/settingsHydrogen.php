<?php
$logo_image="images/logo.png";

$navbar_links[0]=array("name"=>'<img src="images/logo.png" height="16">',"href"=>"index.php","class"=>"w3-theme-l1");
$navbar_links[1]=array("name"=>"Home","href"=>"index.php","class"=>"w3-hide-small w3-hover-white");
//$navbar_links[2]=array("name"=>"About","href"=>"index.php","class"=>"w3-hide-small w3-hover-white");
$navbar_links[2]=array("name"=>"Demo","href"=>"demo.php","class"=>"w3-hide-small w3-hover-white");

$sidebar_links[0]=array("name"=>"List","href"=>"reminders.php","class"=>"w3-hover-black");
$sidebar_links[1]=array("name"=>"New","href"=>"edit_reminder.php?ID=new","class"=>"w3-hover-black");
$sidebar_links[2]=array("name"=>"Demo","href"=>"demo.php","class"=>"w3-hide-large w3-hide-medium w3-hover-white");

$footer_text="This page was generated at " . date("Y-m-d H:i:s");

$settings['DEFAULT_DB_TYPE'] = "mysql";
$settings['DEFAULT_DB_USER'] = "lithium_app";
$settings['DEFAULT_DB_HOST'] = "localhost";
$settings['DEFAULT_DB_INST'] = "lithium";
$settings['DEFAULT_DB_MAXRECS'] = 50;

//This has been moved to a separate file ignored by git: settingsPasswords.php
$settings['DEFAULT_DB_PASS'] = "xxxxxxxx"; // set default database password

$settings['search_page']="index.php";
$settings['login_page'] = "login.php";
$settings['prompt_reg']='0';
$hideSearchForm = true;

?>
