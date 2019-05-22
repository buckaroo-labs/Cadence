<?php
require_once 'common.php';

//In theory, the SQLBuilder class will sanitize 
//	all the POST variables used as column data

function calculate_weekdays() {
	global $sqlb;
	$daysOfWeek="";
	if (isset($_POST['MondayYN'])) $daysOfWeek .= "M";
	if (isset($_POST['TuesdayYN'])) $daysOfWeek .= "T";
	if (isset($_POST['WednesdayYN'])) $daysOfWeek .= "W";
	if (isset($_POST['ThursdayYN'])) $daysOfWeek .= "t";
	if (isset($_POST['FridayYN'])) $daysOfWeek .= "F";
	if (isset($_POST['SaturdayYN'])) $daysOfWeek .= "S";
	if (isset($_POST['SundayYN'])) $daysOfWeek .= "s";	
	if ($daysOfWeek!="") $sqlb->addColumn("days_of_week",$daysOfWeek);
	return 1;
}
function calculate_blackout_hours () {
	global $sqlb;
	if (isset($_POST['SilentHoursYN'])) {
		if (isset(_POST['TimeOfDayStart'])) {  
			$startTime=$_POST['TimeOfDayStart'];
			$startTime=str_replace($startTime,":","");
			$startTime=substr($startTime,1,4);
			$sqlb->addColumn("day_start",$startTime);
		}
		if (isset(_POST['TimeOfDayEnd'])) {  
			$endTime=$_POST['TimeOfDayEnd'];
			$endTime=str_replace($endTime,":","");
			$endTime=substr($endTime,1,4);
			$sqlb->addColumn("day_end",$endTime);
		}
	}
	return 1;
}

function calculate_seasonality() {
	global $sqlb;
	//UI year starts at day 1; DB year starts at day zero
	if (isset($_POST['SilentDaysYN'])) {
		if (isset(_POST['season_start'])) {  
			$startday= (int) $_POST['season_start'] -1;
			$sqlb->addColumn("day_start",$startday);
		}
		if (isset(_POST['season_end'])) {  
			$endday= (int) $_POST['season_end'] -1;
			$sqlb->addColumn("day_end",$endday);
		}
	}
	return 1;
}
function calculate_enddate() {
	global $sqlb;
	if (($_POST['EndDate'])!="")  {
		$endDate=$_POST['EndDate'];
			if (($_POST['EndTime'])!="") {
				$endDate .= " " . $_POST['EndTime'];
			}
		$sqlb->addColumn("end_date",$endDate);
	}
	return 1;
}		
		
function calculate_duedate() {
	global $sqlb;		
	global $startDate;
	$columns = array('grace_scale','grace_units');
	if (isset($_POST['GraceTime'])) {
		if($_POST['GraceTime']=="DueYN") {
			$sqlb->addVarColumns($columns);
			$interval ="+" . $_POST['grace_units'] . " " . decode_scale($_POST['grace_scale']);
			$dueDate = strtotime($interval,$startDate);
			$dueDateStr = date("Y-m-d H:i:s",$dueDate);
			$sqlb->addColumn("due_date",$dueDateStr);
		}
	}
	return 1;
}
		
function calculate_alarms() {
	global $sqlb;
	global $startDate;
	$columns = array('passive_scale',					
					'passive_units',
					'alarm_interval_scale',
					'alarm_interval_units'
					);
	if (isset($_POST['Alarms'])){
		if($_POST['Alarms']=="AlarmYN") {
			$sqlb->addVarColumns($columns);
			$interval ="+" . $_POST['passive_units'] . " " . decode_scale($_POST['passive_scale']);
			$alarmDate = strtotime($interval,$startDate);	
			$almDateStr = date("Y-m-d H:i:s",$alarmDate);			
			$sqlb->addColumn("active_date",$almDateStr);
		}
	}
	return 1;
}		
		
if ($_POST['ID']=="new") {
	$timestamp = (string) time();	
	$sqlb = new SQLBuilder("INSERT");
	$sqlb->setTableName("reminder");
	$sqlb->addColumn("owner",$_SESSION['username']);
	$sqlb->addColumn("sequence",$timestamp);
	//process POST variables into sanitized SQL insert
	
	//some are easy
	$columns = array('title',
					'description',
					'notes',
					'category',
					'priority',
					'snooze_scale',
					'snooze_units'					
					);
	$sqlb->addVarColumns($columns);
	
	//others require more processing
	
	$startDateStr=$_POST['StartDate'] . " " . $_POST['StartTime'];
	$sqlb->addColumn("start_date",$startDateStr);
	$startDate= strtotime($startDateStr);
	
	//Recurrence
	$columns = array('recur_scale','recur_units','recur_float');
	if (isset($_POST['Recurrence'])) {
		if($_POST['Recurrence']=="RecurYN") $sqlb->addVarColumns($columns);
	}
	
	$return=calculate_duedate();
	$return=calculate_alarms();
	$return=calculate_seasonality() ;
	$return=calculate_blackout_hours();
	$return=calculate_enddate();		
	$return=calculate_weekdays();
	
	//Cross your fingers
	$SQL=$sqlb->getSQL();
	$dds->setSQL($SQL);
	echo "<P>" . $SQL . "</P>";
} else {
//not "new"	
	if (isset($_POST['DIRTY'])) {
		$sqlb = new SQLBuilder("UPDATE");
		$sqlb->setTableName("reminder");
		//oops! this part is important:
		$sqlb->addWhere("id='" .  (int) $_POST['ID']. "'");
		$sqlb->addWhere("owner='" .  $_SESSION['username']. "'");
		
		
		$sqlb->addColumn("owner",$_SESSION['username']);
		//process POST variables into sanitized SQL insert
		
		//some are easy
		$columns = array('title',
						'description',
						'notes',
						'category',
						'priority',
						'snooze_scale',
						'snooze_units'					
						);
		$sqlb->addVarColumns($columns);
		
		//others require more processing
		
		$startDateStr=$_POST['StartDate'] . " " . $_POST['StartTime'];
		$sqlb->addColumn("start_date",$startDateStr);
		$startDate= strtotime($startDateStr);
		
		//Recurrence
		$columns = array('recur_scale','recur_units','recur_float');
		if (isset($_POST['Recurrence'])) {
			if($_POST['Recurrence']=="RecurYN") $sqlb->addVarColumns($columns);
		}
		
		$return=calculate_duedate();
		$return=calculate_alarms();
		$return=calculate_seasonality() ;
		$return=calculate_blackout_hours();
		$return=calculate_enddate();		
		$return=calculate_weekdays();
		
		//Cross your fingers
		$SQL=$sqlb->getSQL();
		$dds->setSQL($SQL);
		//echo "<P>" . $SQL . "</P>";
		
	} //dirty


} //not new

$reminderID = (int) $_POST['ID'];

?>