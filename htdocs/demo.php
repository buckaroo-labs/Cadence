<?php 
$pagetitle="Demo | Cadence";
$headline = '<h1>Cadence</h1><h3>Keeping in step</h3>' ;
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

	//create sample data
	$demo_sql[0]="delete from reminder where owner='$owner'";

	$demo_sql[1]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1000 + $temp,'$owner','default','feed cat','description')";
	$demo_sql[2]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1001 + $temp,'$owner','default','ship orders','description')";
	$demo_sql[3]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1002 + $temp,'$owner','default','read news','description')";
	$demo_sql[4]="INSERT INTO reminder(sequence,owner,category,title,description) VALUES (1003 + $temp,'$owner','default','write code','description')";
	$demo_sql[5]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, days_of_week) VALUES (1004 + $temp,'$owner','current','kick ass','MWF',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),'MWF')";
	$demo_sql[6]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, days_of_week) VALUES (1005 + $temp,'$owner','current','take names','Tu Thu Weekend',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),'TtSs')";
	$demo_sql[7]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, season_start, season_end) VALUES (1006 + $temp,'$owner', 'current','hike','summer',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),90,270)";
	$demo_sql[8]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, season_start, season_end) VALUES (1007 + $temp,'$owner', 'current','hibernate','winter',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),271,89)";
	$demo_sql[9]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, day_start, day_end) VALUES (1008 + $temp,'$owner', 'current','sunbathe','day',subtime(current_timestamp(),'2000000'),addtime(current_timestamp(),'3000000'),0600,1800)";
	$demo_sql[10]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, day_start, day_end) VALUES (1009 + $temp,'$owner', 'current','stargaze','night',subtime(current_timestamp(),'1000000'),addtime(current_timestamp(),'4000000'),1800,0600)";
	$demo_sql[11]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date) VALUES (1010 + $temp,'$owner','future','change passwords','future',addtime(current_timestamp(),'6000000'),addtime(current_timestamp(),'25000000'))";
	$demo_sql[12]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date) VALUES (1011 + $temp,'$owner','future','wash dishes','future',addtime(current_timestamp(),'5000000'),addtime(current_timestamp(),'15000000'))";
	$demo_sql[13]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date, snooze_date) VALUES (1012 + $temp,'$owner','overdue','goof off','overdue but snoozed',subtime(current_timestamp(),'25000000'),subtime(current_timestamp(),'8000000'),addtime(current_timestamp(),'3000000'))";
	$demo_sql[14]="INSERT INTO reminder(sequence,owner,category,title,description, start_date, due_date) VALUES (1013 + $temp,'$owner','overdue','answer mail','overdue',subtime(current_timestamp(),'15000000'),subtime(current_timestamp(),'5000000'))";

	$demo_sql[15]="UPDATE reminder set recur_units=1, grace_units=3, passive_units=2, recur_scale=0 where title='kick ass' and owner='$owner'";
	$demo_sql[16]="UPDATE reminder set recur_units=1, grace_units=3, passive_units=2, recur_scale=1 where title='take names' and owner='$owner'";
	$demo_sql[17]="UPDATE reminder set recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where title='answer mail' and owner='$owner'";
	$demo_sql[18]="UPDATE reminder set recur_units=2, grace_units=3, passive_units=2, recur_scale=1 where title='goof off' and owner='$owner'";
	$demo_sql[19]="UPDATE reminder set recur_units=3, grace_units=3, passive_units=2, recur_scale=1 where title='hike' and owner='$owner'";
	$demo_sql[20]="UPDATE reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where title='hibername' and owner='$owner'";
	$demo_sql[21]="UPDATE reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=1 where title='sunbathe' and owner='$owner'";
	$demo_sql[22]="UPDATE reminder set recur_units=3, grace_units=6, passive_units=4, recur_scale=2 where title='stargaze' and owner='$owner'";
	$demo_sql[23]="UPDATE reminder set recur_units=4, grace_units=6, passive_units=4, recur_scale=3 where title='read news' and owner='$owner'";
	$demo_sql[24]="UPDATE reminder set recur_units=4, grace_units=6, passive_units=4, recur_scale=4 where title='write code' and owner='$owner'";

	$demo_msg="<p>You are logged in anonymously as '" . $_SESSION['username'] . "' and sample data has been loaded into your reminder list. This data and any reminders you create will no longer be accessible to you after your browser session ends.</p>";
	
	for ($x = 0; $x <= 24; $x++) {
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




