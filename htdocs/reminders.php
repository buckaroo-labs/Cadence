
<?php 
$pagetitle="Reminders | Cadence";
$headline = '<h1>Cadence</h1>' ;
include "Hydrogen/pgTemplate.php";
require_once 'Hydrogen/libDebug.php';
require_once 'common.php';
?>


<script>
$(document).ready(function(){
  $(".mark_reminder_complete").html('<img src="images/checkbox.png" height="16">');
  $(".edit_reminder").html('<img src="images/edit.png" height="16">');
});


</script>



<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main w3-container w3-padding-16" style="margin-left:250px">

<?php 
include 'Hydrogen/elemLogoHeadline.php';  

function show_upcoming () {
		global $dds;
		global $address_classes;
		global $linkURLs;
		global $linkTargets;
		global $keycols;
		global $invisible;
			
		/*
		
		SQL FOR UPCOMING REMINDERS
		
		*/
		$sql = "select id as '(edit)', title as 'Title', date_format(start_date,'%M %D') as 'Start', date_format(due_date,'%M %D') as 'Due'";
		$sql = $sql . "	from reminder where owner='" . $_SESSION['username'] . "' ";
		$sql = $sql . " and ifnull(start_date,now()- interval 1 day) BETWEEN current_timestamp() and date_add(current_timestamp(), interval 90 day)  ";
		//$sql = $sql . " and ifnull(snooze_date,now()- interval 1 day) > current_timestamp()";
		
		$sql = $sql . " and ifnull(end_date,now()+ interval 1 day) > now() ";

		$sql = $sql . " ORDER BY start_date";
		
		//echo "<P>SQL:" . $sql . "</P>";

		$result = $dds->setMaxRecs(50);
		$result = $dds->setSQL($sql);
		$page_count = $dds->getPageCount();
		if ($page_count>0) {
			unset($address_classes);
			unset($linkURLs);
			unset($linkTargets);
			unset($keycols);
			unset($invisible);
			unset($hide_headers);
			$linkURLs[0] = 'edit_reminder.php?ID=';
			$keycols=array();
			$invisible=array();
			$hide_headers[0] = 1;
			$address_classes[0]='edit_reminder';			
			echo "<H3>Upcoming</h3>";
			$table=new HTMLTable($dds->getFieldNames(),$dds->getFieldTypes());
			$table->defineRows($linkURLs,$keycols,$invisible,$address_classes,$link_targets,$hide_headers);
			$table->start();
			while ($result_row = $dds->getNextRow()){
				$table->addRow($result_row);
			}
			$table->finish();
		}
	
}	
	 

if (isset($_SESSION['username'])) {
	require_once 'Hydrogen/clsDataSource.php';
	require_once 'Hydrogen/clsHTMLTable.php';
	require_once 'Hydrogen/libFilter.php';

	if (isset($_GET['mark_complete'])) {
		
			//echo "<P>GET:" . $_GET['mark_complete'] . "</P>";
			$markcomplete = (int)$_GET['mark_complete'];
			
			//check first if there are any matching records. Ignore if none, because this will happen on page refresh or bookmark
			$sql = "SELECT count(*) FROM reminder ";
			$sql = $sql . " WHERE sequence=" . $markcomplete . " AND owner='" . $_SESSION['username'] . "' ";
			$result = $dds->setSQL($sql);
			$result_row = $dds->getNextRow();
			if ($result_row[0] > 0) {
				$sql = "SELECT id, recur_float, recur_scale, recur_units, start_date, grace_scale, grace_units, passive_scale, passive_units FROM reminder ";
				$sql = $sql . " WHERE sequence=" . $markcomplete . " AND owner='" . $_SESSION['username'] . "' ";
				$result = $dds->setSQL($sql);
				$result_row = $dds->getNextRow("labeled");	
				
				$sql =  "UPDATE reminder SET complete_date='" . date("Y-m-d H:i:s") . "', ";
				
				//check for recurrence
				if (!is_null($result_row['recur_units'])) {
					debug("recurring task completed");
					$recurscale = decode_scale($result_row['recur_scale']);
					$gracescale = decode_scale($result_row['grace_scale']);
					$passivescale = decode_scale($result_row['passive_scale']);
					
					if ($result_row['recur_float']==0) {
						$initdate = strtotime($result_row['start_date']);
						debug("recurrence set as fixed, with base date: " .$result_row['start_date']);
					} else {
						$initdate=time();
						debug("recurrence set as floating");
					}	
					debug("recurrence will follow date:" . date("Y-m-d H:i:s",$initdate));
					//Calculate the next correct start time	
					debug("next start: " . "+" . $result_row['recur_units'] . " " . $recurscale);
					$starttime = strtotime("+" . $result_row['recur_units'] . " " . $recurscale, $initdate );
					//Format it for MySQL
					$startdate = date("Y-m-d H:i:s",$starttime);
					debug("next recurrence date:" . $startdate);
					debug("next recurrence due: " . "+" . $result_row['grace_units'] . " " . $gracescale);
					$duetime = strtotime("+" . $result_row['grace_units'] . " " . $gracescale,$starttime);
					$duedate = date("Y-m-d H:i:s",$duetime);
					debug("next recurrence due date:" . $duedate);
					debug("next recurrence active: " . "+" . $result_row['passive_units'] . " " . $passivescale);
					$activetime = strtotime("+" . $result_row['passive_units'] . " " . $passivescale,$starttime) ;
					$activedate = date("Y-m-d H:i:s",$activetime);
					debug("next recurrence active date:" . $activedate);
					
					$sql = $sql . " start_date='" . $startdate . "', ";				
					$sql = $sql . " due_date='" . $duedate . "', ";	
					$sql = $sql . " active_date='" . $activedate . "', ";	
					debug($sql);
					
				} else {
					//non-recurring reminder will be expired
					$sql = $sql . " end_date='" . date("Y-m-d H:i:s",strtotime("-1 second")) . "', ";
				}
				$timestamp = (string) time();
				$sql = $sql . " sequence=" . $result_row['id'] . '000' .  $timestamp . ", ";
				$sql = $sql . " last_updated='" . date("Y-m-d H:i:s") . "' ";
				$sql = $sql . " WHERE id=" . $result_row['id'] . " AND owner='" . $_SESSION['username'] . "' ";
				//echo "<P>SQL:" . $sql . "</P>";
				$result = $dds->setSQL($sql);
			} //if count > 0
	}
	
	$timeofday = date("Hi");
	$dayofyear = date("z");
	$dayofweek = date("l");
	//Day name comparisons will be made on first character. 
	//Distinguish e.g. T(hursday) from T(uesday) by changing case
	if ($dayofweek=="Thursday") $dayofweek = strtolower($dayofweek); 
	if ($dayofweek=="Sunday") $dayofweek = strtolower($dayofweek);
	
	/*
		
		SQL FOR CURRENT REMINDERS
		
	*/
	
	$sql = "select sequence as '(check)', id as '(edit)', title as 'Title', date_format(start_date,'%M %D') as 'Start', date_format(due_date,'%M %D') as 'Due'";
	$sql .= ", CASE WHEN due_date < NOW() THEN 1 ELSE 0 END as overdue ";
	$sql = $sql . "	from reminder where owner='" . $_SESSION['username'] . "' ";
	$sql = $sql . " and ifnull(start_date,now()- interval 1 day) < current_timestamp() ";
	$sql = $sql . " and ifnull(snooze_date,now()- interval 1 day) < current_timestamp() ";
	
	$sql = $sql . " AND CASE WHEN ifnull(day_start,0) < ifnull(day_end,2359) THEN " . $timeofday . "  BETWEEN ifnull(day_start,0) and ifnull(day_end,2359) ELSE " . $timeofday . "  NOT BETWEEN ifnull(day_end,2359) and ifnull(day_start,0) END ";

	$sql = $sql . " AND CASE WHEN ifnull(season_start,0) < ifnull(season_end,364) THEN " . $dayofyear . " BETWEEN ifnull(season_start,0) and ifnull(season_end,364) ELSE " . $dayofyear .  " NOT BETWEEN ifnull(season_end,364) and ifnull(season_start,0) END ";

	$sql = $sql . " and ifnull(days_of_week,'MTWtFSs') like '%" . substr($dayofweek,0,1) . "%'";
	
	$sql = $sql . " and ifnull(end_date,now()+ interval 1 day) > now()";
	$sql = $sql . " ORDER BY ifnull(due_date,now()+ interval 99 year)";
	//echo "<P>SQL:" . $sql . "</P>";

	$result = $dds->setMaxRecs(50);
	$result = $dds->setSQL($sql);
	$page_count = $dds->getPageCount();
	if ($page_count>0) {
		unset($address_classes);
		unset($linkURLs);
		unset($linkTargets);
		unset($keycols);
		unset($invisible);
		unset($hide_headers);
		$linkTargets=null;
		$keycols=null;
		$invisible=null;
		$invisible[5] = 1;
		$linkURLs[0] = 'reminders.php?mark_complete=';
		$address_classes[0]='mark_reminder_complete';
		$linkURLs[1] = 'edit_reminder.php?ID=';
		$address_classes[1]='edit_reminder';
		$linkURLs[2] = 'view_reminder.php?ID=';
		$keycols[2] = 1;
		$hide_headers[0]=1;
		$hide_headers[1]=1;
		$hide_headers[5]=1;		
		//$address_classes[2]='view_reminder';
		echo "<H3>Current</h3>";
		$table=new HTMLTable($dds->getFieldNames(),$dds->getFieldTypes());
		$table->defineRows($linkURLs,$keycols,$invisible,$address_classes,$linkTargets,$hide_headers);
		$table->start();
		while ($result_row = $dds->getNextRow()){
			$style='background-color: #a4f995; color: black';
			if (strlen($result_row[4]) > 1 ) $style='background-color: #f5f9b1; color: black';
			if ($result_row[5] == 1 ) $style='background-color: #f44d1f; color: white';
			$table->addRow($result_row,$style); 
		}
		$table->finish();
		
		show_upcoming();
	} else {
		echo '<h3>No current reminders.</h3><p> Are you all caught up? Excellent!</p>';	
		show_upcoming();
	}
} else {
	echo '<P>Not logged in.</p>';	
}	
?>

<!-- END MAIN -->
<p></p>
<p></p>
</div>

<?php include "Hydrogen/elemNavbar.php"; ?>
<?php include "Hydrogen/elemFooter.php"; ?>
</body></html>
