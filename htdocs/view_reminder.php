
<?php 
$pagetitle="Reminder | Lithium";
$headline = '<h1>Lithium</h1><h3>One step at a time</h3>' ;
include "Hydrogen/pgTemplate.php";
require_once 'Hydrogen/libDebug.php';
$this_page="view_reminder.php"
?>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main w3-container w3-padding-16" style="margin-left:250px">

<?php 

//unset these to remove the elements from the page, but include elemLogoHeadline to push the main section below the nav bar. Find a cleaner way of doing this later.
unset ($logo_image);
unset ($headline);
include 'Hydrogen/elemLogoHeadline.php';  

if (isset($_SESSION['username'])) {
	require_once 'Hydrogen/clsDataSource.php';
	require_once 'Hydrogen/clsHTMLTable.php';
	require_once 'Hydrogen/libFilter.php';
	require_once 'Hydrogen/clsSQLBuilder.php';
/*	
	foreach($_POST as $key => $value) {
		if ($value <> "") {
			echo ("<h4>" . $key . "=" . $value . "</h4>");
		} else {
			echo ("<p>" . $key . "=" . $value . "</p>");
		}
	}
*/
	if (isset($_POST['ID'])) include "post_reminder.php";
	
	//display the reminder as read-only
	

	if (isset($_GET['ID'])) $reminderID = $_GET['ID'];

	if ($reminderID=="new") {
		$where="sequence=" . $timestamp;
	} else {
		$where="id=" . $reminderID;
	}

	$result = $dds->setSQL("SELECT * FROM reminder WHERE  ". $where . " AND owner ='" . $_SESSION['username'] . "'");
	$remdata = $dds->getNextRow("labeled");

	$startdatestr = date("Y-m-d",strtotime($remdata['start_date']));
	$starttimestr = date("H:i",strtotime($remdata['start_date']));

	$output = "The reminder titled '" . $remdata['title'] . "' is set for " . $startdatestr . " at " . $starttimestr;

	if (isset($remdata['end_date'])) {
		if (!is_null($remdata['end_date'])) {

		$enddatestr = date("Y-m-d",strtotime($remdata['end_date']));
		$endtimestr = date("H:i",strtotime($remdata['end_date']));
		$output .= " and will not recur after " . $enddatestr  . " at " . $endtimestr;
		}
	}
	$output .=". " ;
	
	//all of the below can be used in a later release to add more output.
	
	$priority = $remdata['priority'];
	$recur_float = $remdata['recur_float'];
	$recur_units = $remdata['recur_units'];
	$recur_scale = $remdata['recur_scale'];
	$grace_units = $remdata['grace_units'];
	$grace_scale = $remdata['grace_scale'];
	$passive_units = $remdata['grace_units'];
	$passive_scale = $remdata['grace_scale'];
	$alarm_interval_units = $remdata['alarm_interval_units'];
	$alarm_interval_scale = $remdata['alarm_interval_scale'];
	$snooze_units = $remdata['snooze_units'];
	$snooze_scale = $remdata['snooze_scale'];
	$days_of_week= "_" . $remdata['days_of_week'];
	if(is_null($remdata['days_of_week'])) $days_of_week="_MTWtFSs";
	if (!is_null($remdata['season_start'])) {
		$blackout_days=true;
		$season_start= (int) $remdata['season_start'] + 1;
	} else {
		$season_start= "1";
	}
	if (!is_null($remdata['season_end'])) {
		$blackout_days=true;
		$season_end= (int) $remdata['season_end'] +1;
	} else {
		$season_end= "365";
	}
	if (!is_null($remdata['day_start'])) {
		$blackout_hours=true;
		$temp = (string) $remdata['day_start'];
		$tempmin = substr($temp,1,-2);
		$temphour = str_replace($tempmin,'',$temp);
		$tempminute = (int) $tempmin;
		if ($tempminute > 59) $tempminute=59;
		if ($tempminute < 10) $tempminute= "0" . $tempminute;
		if ($temphour < 10) $temphour= "0" . $temphour;
		$tod_start= $temphour . ":" . $tempmin ;
	} else {
		$tod_start= "00:00";
	}
	if (!is_null($remdata['day_end'])) {
		$blackout_hours=true;
		$temp = (string) $remdata['day_end'];
		$tempmin = substr($temp,1,-2);
		$temphour = str_replace($tempmin,'',$temp);
		$tempminute = (int) $tempmin;
		if ($tempminute > 59) $tempminute=59;
		if ($tempminute < 10) $tempminute= "0" . $tempminute;
		if ($temphour < 10) $temphour= "0" . $temphour;
		$tod_end= $temphour . ":" . $tempmin ;
	} else {
		$tod_end= "23:59";
	}
	echo "<p>" . $output . "</p>" . '<p><a href="edit_reminder.php?ID=' . $remdata['id'] . '">Edit</a></p>';

	
} else {
	echo '<P>Not logged in.</p>';	
}	
?>
<!-- END MAIN -->
<p></p>
<p></p>
</div>

<?php include "Hydrogen/elemFooter.php"; ?>
</body></html>
