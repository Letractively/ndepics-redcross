<?php

//************************************
// Summer 2011: Daniel Bolivar (dbolivar@nd.edu)
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// insertEmployeeReport.php - This uses PHP to recieve relevant variables from the Employee version mobile app and insert them into the database.
//************************************

include("./config/functions.php");
include("./config/open_database.php");

// This obtains the information from the mobile app or from createEmployeeReport.php
$dr_number = $_POST["dr_number"];
$dr_name = $_POST["dr_name"];
$state = strtoupper($_POST["state"]);
$county = $_POST["county"];
$city = $_POST["city"];
$report_time = $_POST["report_time"];

$street_name = $_POST["street_name"];
$geo_ref = $_POST["geo_ref"];

$house_number = $_POST["house_number"];
$apartment_number = $_POST["apartment_number"];

$damage_classification = $_POST["damage_classification"];
$dwelling_type = $_POST["dwelling_type"];

$floor_count = $_POST["floor_count"];
$basement_bool = $_POST["basement_bool"];
$water_living_area_inches = $_POST["water_living_area_inches"];
$water_basement_inches = $_POST["water_basement_inches"];
$electricity_bool = $_POST["electricity_bool"];
$occupancy_type = $_POST["occupancy_type"];

$or_901 = $_POST["or_901"];
$description = $_POST["description"];
$resident_name = $_POST["resident_name"];

$image_bool = $_POST["image_bool"];

// This checks whether there is an image attached with the report from the mobile app.
if($image_bool){
	$image_file_name = $_POST["image_file_name"].".jpg";
}

// This is coming from createEmployeeReport.php and not the mobile app.
if($image_bool == "testing"){
	// A blank file name means that there is no image.
	if($_FILES['image']['name'] == ""){
		$image_bool = 0;
	}
	// There is an image from createCitizenReport.php
	else{
		$image_bool = 1;
		$image_file_name = $_FILES['image']['name'];
	}
}

$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];
$username = $_POST["username"];

// This inserts the employee report into the database.
$query = "INSERT INTO rc_employee_reports (";

$query = $query."dr_number, dr_name, state, county, city, report_time,
			street_name, geo_ref, house_number, apartment_number,
			damage_classification, dwelling_type, floor_count, 
			basement_bool, water_living_area_inches, water_basement_inches, electricity_bool,
			occupancy_type, or_901, description, resident_name, time_received, image_bool,";
if($image_bool){
	$query = $query."image_file_name,";
}
$query = $query." latitude, longitude, username)";

$query = $query."VALUES(";

$query = $query."'$dr_number', '$dr_name', '$state', '$county', '$city', '$report_time',
			'$street_name', '$geo_ref', '$house_number', '$apartment_number',
			'$damage_classification', '$dwelling_type', '$floor_count',
			'$basement_bool', '$water_living_area_inches', '$water_basement_inches', '$electricity_bool',
			'$occupancy_type', '$or_901', '$description', '$resident_name', DATE_ADD(NOW(), INTERVAL 3 HOUR), '$image_bool',";
if($image_bool){
	$query = $query."'$image_file_name', ";
}
$query = $query." '$latitude', '$longitude', '$username')";

$result = mysql_query($query) or die (mysql_error());

// This inserts the employee report's image into employee_images
if($image_bool){
	$temp = $_FILES["image"]["tmp_name"];
	$errorCheck = $_FILES["image"]["error"];

	if($errorCheck > 0){
		echo "Error: Employee Report's Image is invalid";
	}
	else{
		$image_file_dir = "employee_images/".$image_file_name;
		$moved = move_uploaded_file($temp,$image_file_dir);
	}
}

// This sends an e-mail notification to the submitter.
$query2 = "SELECT * FROM users WHERE username='$username'";
$result2 = mysql_query($query2) or die(mysql_error());
$person = mysql_fetch_array($result2);

$mail_to = $person["email"];
$cellPhone = $person["cellPhone"];
$cellCarrier = $person["cellCarrier"];

$mail_subject = "Employee Report Submitted";
$mail_message = "
	Your report to St. Joseph County Red Cross Chapter has been submitted.
	Thank you.
	";
$mail_message = wordwrap($mail_message, 70);
$mail_header = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
mail($mail_to, $mail_subject, $mail_message, $mail_header);

// This sends a text message to the submitter.
$smsGatewayEmail = emailToSms($cellPhone,$cellCarrier);
mail($smsGatewayEmail, $mail_subject, $mail_message, $mail_header);

session_start();
// This re-direct if the report was inserted using the web interface.
if($_SESSION["valid"] == "valid"){
	header( 'Location: ./home.php' );
}

include("./config/close_database.php");

?>