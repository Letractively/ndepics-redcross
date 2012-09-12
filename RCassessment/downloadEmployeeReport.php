<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// downloadEmployeeReport.php - Put all the relevant employee reports into a CSV file and the relevant employee images into a downloadable zip file.
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");

$serial = $_POST["serial"];
// This obtains the entries shown in tableCitizenReport.php
if($serial != ''){
	// This obtains the serialized string and unserializes it into an array.
	$downloadTheseEntries = unserialize(stripslashes($serial));
	$query = "SELECT * FROM rc_employee_reports WHERE ";
	for($i=0; $i < count($downloadTheseEntries); $i++){
		$query = $query."entry_id = '$downloadTheseEntries[$i]' OR ";
	}
	// This removes the last OR.
	$query = substr($query,0, -3);
}
// This obtains all the entries in the Citizen database.
else{
	$query = "SELECT * FROM rc_employee_reports";
}
$result = mysql_query($query) or die("Error: Viewing Employee Reports");

// This opens the output file.
$openFile = fopen("employeeReports.csv", "w");
if(!$openFile){
	print "Error: Could not open employeeReports.csv";
}

// The first line of the report file are the categories.
$fieldCount = mysql_num_fields($result);
for($i=0; $i < $fieldCount; $i++){
	fwrite($openFile, '"'.mysql_field_name($result, $i).'",');
	print '"'.mysql_field_name($result,$i).'",';
}
fwrite($openFile, "\n");
print "\n<br />";

// This shows the other lines of the CSV.
while($row = mysql_fetch_array( $result )){
	for($i=0; $i < $fieldCount; $i++){
		fwrite($openFile,'"'.$row[$i].'",');
		print '"'.$row[$i].'",';
	}
	fwrite($openFile, "\n");
	print "\n<br />";
}

// This closes the output file.
$closeFile = fclose($openFile);
if(!$closeFile){
	print "Error: Could not close employeeReports.csv";
}

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>

<!-- This allows the user to download the csv file. -->
<script type='text/javascript'>
	window.location.href = './employeeReports.csv';
</script>