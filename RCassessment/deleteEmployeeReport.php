<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// deleteEmployeeReport.php - This deletes a employee report.
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");

// This variable is obtained from tableEmployeeReport.php
$entry_id = $_POST["entry_id"];

// This deletes the image associated with the report in the employee_images folder.
$query = "SELECT * FROM rc_employee_reports WHERE entry_id='$entry_id'";
$result = mysql_query($query) or die(mysql_error());
while($report = mysql_fetch_array( $result )){
	if($report['image_bool']){
		$temp = unlink('./employee_images/'.$report['image_file_name']);
	}
}

// This deletes the entry associate with the report in the database.
$query2 = "DELETE FROM rc_employee_reports WHERE entry_id='$entry_id'";
$result2 = mysql_query($query2) or die(mysql_error());

include("./config/close_database.php");

// This re-directs the user to the tableCitizenReport.php with the same search parameters.
$redirectTo = $_SERVER['HTTP_REFERER'];
$redirectTo = "Location:".$redirectTo;
header($redirectTo);

?>