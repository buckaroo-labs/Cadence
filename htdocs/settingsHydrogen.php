<?php
$logo_image="images/logo.jpg";

$navbar_links[0]=array("name"=>'<img src="images/logo_tn">',"href"=>"index.php","class"=>"w3-theme-l1");
$navbar_links[1]=array("name"=>"Home","href"=>"./","class"=>"w3-hide-small w3-hover-white");
$navbar_links[2]=array("name"=>"About","href"=>"#","class"=>"w3-hide-small w3-hover-white");

$sidebar_links[0]=array("name"=>"List","href"=>"reminders.php","class"=>"w3-hover-black");
$sidebar_links[1]=array("name"=>"New","href"=>"edit_reminder.php?ID=new","class"=>"w3-hover-black");

$footer_text="This page was generated at " . date("Y-m-d H:i:s");

define ("DEFAULT_DB_TYPE","mysql"); 	// set default database type
define ("DEFAULT_DB_USER","lithium_app"); 	// set default database user
define ("DEFAULT_DB_HOST","localhost"); // set default database host
define ("DEFAULT_DB_PORT","1521"); 	// set default database port
define ("DEFAULT_DB_INST","lithium"); 		// set default database name/instance/schema
define ("DEFAULT_MAX_RECS",50);
//This has been moved to a separate file ignored by git: settingsPasswords.php
//define ("DEFAULT_DB_PASS","xxxxxxx"); // set default database password


define ("DATAFILE_PATH","D:\Code\LAMP\Lithium\htdocs");
define ("WEBROOT","D:\Code\LAMP\Lithium\htdocs");
define ("DEBUG",true);
define ("DEBUG_PATH","D:\Code\LAMP\Lithium\htdocs\debug.txt");

$settings['search_page']="index.php";
$settings['login_page'] = "login.php";


?>