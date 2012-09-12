<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// downloadEmployeeImage.php - Go to the employee_images folder and download the relevant images.
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");

// The reports' images to download was obtained from tableEmployeeReport.php as a serialized string.
$serial = $_POST["serial"];

if($serial != ''){
	// The serialized string is unserialized into an array.
	$downloadTheseEntries = unserialize(stripslashes($serial));
	$query = "SELECT * FROM rc_employee_reports WHERE ";
	for($i=0; $i < count($downloadTheseEntries); $i++){
		$query = $query."entry_id = '$downloadTheseEntries[$i]' OR ";
	}
	// This removes the last OR.
	$query = substr($query,0, -3);
}
// This obtains all the entries in the Employee database.
else{
	$query = "SELECT * FROM rc_employee_reports";
}
$result = mysql_query($query) or die("Error: Viewing Employee Reports");

// This creates a zip file with all the relevant images.
$zip = new ZipArchive;
$zip->open('employeeImageFiles.zip', ZipArchive::OVERWRITE);
while($report = mysql_fetch_array($result)){
	if($report['image_bool']){
		$zip->addFile('./employee_images/'.$report['image_file_name']);
	}
}
$zip->close();

// This allows the user to download the zip file.
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename=employeeImageFiles.zip');
readfile('employeeImageFiles.zip');

include("./config/close_database.php");

?>