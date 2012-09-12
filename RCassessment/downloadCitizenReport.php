<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// downloadCitizenReport.php - Put all the relevant citizen reports into a CSV file and the relevant citizen images into a downloadable zip file.
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");

// The reports' images to download was obtained from tableCitizenReport.php as a serialized string
$serial = $_POST["serial"];
if($serial != ''){
	// The serialized string is unserialized into an array.
	$downloadTheseEntries = unserialize(stripslashes($serial));
	$query = "SELECT * FROM rc_citizen_reports WHERE ";
	for($i=0; $i < count($downloadTheseEntries); $i++){
		$query = $query."entry_id = '$downloadTheseEntries[$i]' OR ";
	}
	// This removes the last OR.
	$query = substr($query,0, -3);
}
// This obtains all the entries in the Citizen database.
else{
	$query = "SELECT * FROM rc_citizen_reports";
}

$result = mysql_query($query) or die("Error: Viewing Citizen Reports");

// This opens the output file.
$openFile = fopen("citizenReports.csv", "w");
if(!$openFile){
	print "Error: Could not open citizenReports.csv";
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
	print "Error: Could not close citizenReports.csv";
}

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>

<!-- This allows the user to download the csv file. -->
<script type='text/javascript'>
	window.location.href = './citizenReports.csv';
</script>