<?php
$settings['DEBUG']=true;
require_once "Hydrogen/libDebug.php";

$logo_image="images/logo.png";

$navbar_links[0]=array("name"=>'<img src="images/logo.png" height="16">',"href"=>"index.php","class"=>"w3-theme-l1");
$navbar_links[1]=array("name"=>"Home","href"=>"index.php","class"=>"w3-hide-small w3-hover-white");
//$navbar_links[2]=array("name"=>"About","href"=>"index.php","class"=>"w3-hide-small w3-hover-white");
$navbar_links[2]=array("name"=>"Demo","href"=>"demo.php","class"=>"w3-hide-small w3-hover-white");


$sidebar_links[0]=array("name"=>"Reminders","href"=>"reminders.php","class"=>"w3-hover-black");
$sidebar_links[1]=array("name"=>"New Reminder","href"=>"edit_reminder.php?ID=new","class"=>"w3-hover-black");
$sidebar_links[2]=array("name"=>"Demo","href"=>"demo.php","class"=>"w3-hide-large w3-hide-medium w3-hover-white");
//$sidebar_links[3]=array("name"=>"Lists","href"=>"calendars.php","class"=>"w3-hover-black");
$sidebar_links[3]=array("name"=>"CalDAV","href"=>"caldav_accounts.php","class"=>"w3-hover-black");

$footer_text="VERSION 2.0 DRAFT // This page was generated at " . date("Y-m-d H:i:s");

$settings['DEFAULT_DB_TYPE'] = "mysql";
$settings['DEFAULT_DB_USER'] = "cadence_app";
$settings['DEFAULT_DB_HOST'] = "localhost";
$settings['DEFAULT_DB_INST'] = "cadence";
$settings['DEFAULT_DB_MAXRECS'] = 999;
debug ("Set DB connection defaults for application");

//This has been moved to a separate file ignored by git: settingsPasswords.php
//$settings['DEFAULT_DB_PASS'] = "xxxxxxxx"; // set default database password

$settings['search_page']="index.php";
$settings['login_page'] = "login.php";
$settings['prompt_reg']='0';
$hideSearchForm = true;


?>
