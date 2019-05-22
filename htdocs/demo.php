<?php 
$pagetitle="Demo | Cadence";
$headline = '<h1>Cadence</h1>' ;
include "Hydrogen/pgTemplate.php";
require "Hydrogen/clsDataSource.php";


//Check if logged in
if (isset($_SESSION['username'])) {
		if (!isset($_SESSION['demo'])) {
			$demo_msg="Log out and return to this page to try the demo data"; 
		} else {
			//The demo is already set up
			$demo_msg="<p>You are logged in anonymously as '" . $_SESSION['username'] . "' and sample data has been loaded into your reminder list. This data and any reminders you create will no longer be accessible to you after your browser session ends.</p>";

		}
} else {
	
	$temp = rand(10000,99999);
	$owner = "Demo" . $temp;
	$_SESSION['username'] = $owner;

	$demo_sql[0]="delete from reminder where owner='$owner'";

	
	//create sample data
	$demo_sql[1]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1000 + $temp,'$owner','default','feed cat','description')";
	$demo_sql[2]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1001 + $temp,'$owner','default','ship orders','description')";
	//$demo_sql[3]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1002 + $temp,'$owner','default','read news','description')";
	//$demo_sql[4]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1003 + $temp,'$owner','default','debug code','description')";


	$demo_sql[3]="INSERT INTO reminder(sequence,owner,category,title,description, start_date) VALUES (1002 + $temp,'$owner','current','read news',null,subtime(current_timestamp(),'1500000'))";


	$demo_sql[4]="INSERT INTO reminder(sequence,owner,category,title,description, start_date) VALUES (1003 + $temp,'$owner','current','debug code',null,subtime(current_timestamp(),'1000000'))";


	$demo_sql[5]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, days_of_week) VALUES (1004 + $temp,'$owner','current','kick ass','Mon Wed Fri',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'3000000'),'MWF')";
	$demo_sql[6]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, days_of_week) VALUES (1005 + $temp,'$owner','current','take names','Tu Thu Weekend',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),'TtSs')";
	$demo_sql[7]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, season_start, season_end) VALUES (1006 + $temp,'$owner', 'current','hike','summer',subtime(current_timestamp(),'500000'),addtime(current_timestamp(),'3000000'),90,270)";
	$demo_sql[8]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, season_start, season_end) VALUES (1007 + $temp,'$owner', 'current','hibernate','winter',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),271,89)";
	$demo_sql[9]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, day_start, day_end) VALUES (1008 + $temp,'$owner', 'current','sunbathe','daytime-only task',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'4000000'),0600,1800)";
	$demo_sql[10]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, day_start, day_end) VALUES (1009 + $temp,'$owner', 'current','stargaze','night',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),1800,0600)";
	$demo_sql[11]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date) VALUES (1010 + $temp,'$owner','future','change passwords','future',addtime(current_timestamp(),'6000000'),addtime(current_timestamp(),'25000000'))";
	$demo_sql[12]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date) VALUES (1011 + $temp,'$owner','future','wash dishes','future',addtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'2000000'))";
	$demo_sql[13]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, snooze_date) VALUES (1012 + $temp,'$owner','overdue','goof off','overdue but snoozed',subtime(current_timestamp(),'25000000'),subtime(current_timestamp(),'8000000'),addtime(current_timestamp(),'3000000'))";
	$demo_sql[14]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date) VALUES (1013 + $temp,'$owner','overdue','answer mail','overdue',subtime(current_timestamp(),'500000'),subtime(current_timestamp(),'5000000'))";

	$demo_sql[15]="UPDATE reminder set active_date=adddate(start_date, interval 2 day), due_date=adddate(start_date, interval 3 day), title='cold calls', recur_units=1, grace_units=3, passive_units=2, recur_scale=2 where title='kick ass' and owner='$owner'";
	$demo_sql[16]="UPDATE reminder set active_date=adddate(start_date, interval 2 day), due_date=adddate(start_date, interval 3 day), title='deliveries',recur_units=1, grace_units=3, passive_units=2, recur_scale=1 where title='take names' and owner='$owner'";
	$demo_sql[17]="UPDATE reminder set active_date=adddate(start_date, interval 2 day), due_date=adddate(start_date, interval 3 day), recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where title='answer mail' and owner='$owner'";
	$demo_sql[18]="UPDATE reminder set active_date=adddate(start_date, interval 2 day), due_date=adddate(start_date, interval 3 day), recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where title='goof off' and owner='$owner'";
	$demo_sql[19]="UPDATE reminder set active_date=adddate(start_date, interval 2 day), due_date=adddate(start_date, interval 3 day), title='cut grass',recur_units=3, grace_units=3, passive_units=2, recur_scale=1 where title='hike' and owner='$owner'";
	$demo_sql[20]="UPDATE reminder set active_date=adddate(start_date, interval 4 day), due_date=adddate(start_date, interval 6 day), title='tire chains',recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where title='hibernate' and owner='$owner'";
	$demo_sql[21]="UPDATE reminder set active_date=adddate(start_date, interval 4 day), due_date=adddate(start_date, interval 6 day), title='wash car',recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where title='sunbathe' and owner='$owner'";
	$demo_sql[22]="UPDATE reminder set active_date=adddate(start_date, interval 4 day), due_date=adddate(start_date, interval 6 day), recur_units=3, grace_units=6, passive_units=4, recur_scale=2 where title='stargaze' and owner='$owner'";
	$demo_sql[23]="UPDATE reminder set active_date=adddate(start_date, interval 4 day), due_date=adddate(start_date, interval 6 day), title='inventory',recur_units=4, grace_units=6, passive_units=4, recur_scale=3 where title='read news' and owner='$owner'";
	$demo_sql[24]="UPDATE reminder set active_date=adddate(start_date, interval 4 day), due_date=adddate(start_date, interval 6 day), recur_units=4, grace_units=6, passive_units=4, recur_scale=4 where title='debug code' and owner='$owner'";

	$demo_sql[25]="UPDATE reminder set title='call Mom' where title='wash dishes' and owner='$owner'";
	$demo_sql[26]="UPDATE reminder set title='redesign website' where title='feed cat' and owner='$owner'";
	$demo_sql[27]="UPDATE reminder set title='edit novel' where title='ship orders' and owner='$owner'";
	
	//$demo_sql[28]="UPDATE reminder set due_date=adddate(start_date, interval grace_units CASE WHEN grace_scale=0 THEN hour WHEN grace_scale=2 THEN week WHEN grace_scale=3 THEN month WHEN grace_scale=4 THEN year ELSE day END) where owner='$owner'";
	//$demo_sql[29]="UPDATE reminder set active_date=adddate(start_date, interval passive_units CASE WHEN passive_scale=0 THEN hour WHEN passive_scale=2 THEN week WHEN passive_scale=3 THEN month WHEN passive_scale=4 THEN year ELSE day END) ) where owner='$owner'";
		
	

	$demo_sql[28]="delete from reminder where created < SUBDATE( CURRENT_DATE, INTERVAL 1 DAY) and owner between 'Demo10000' and 'Demo99999'";

	$demo_msg="<p>You are logged in anonymously as '" . $_SESSION['username'] . "' and sample data has been loaded into your reminder list. This data and any reminders you create will no longer be accessible to you after your browser session ends.</p>";
	
	for ($x = 0; $x <= 28; $x++) {
		$result = $dds->setSQL($demo_sql[$x]);
		//$demo_msg .= "<br>" . $demo_sql[$x];
	}
	

	$_SESSION['demo']="Y";
}


?>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">
<?php include 'Hydrogen/elemLogoHeadline.php';?>
  <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">

		<?php echo "<p>" . $demo_msg . "</p>"; ?>

    </div>
    <div class="w3-third w3-container">
    </div>
  </div>

</div>
<?php include "Hydrogen/elemNavbar.php"; ?>
<?php include "Hydrogen/elemFooter.php"; ?>
</body></html>




