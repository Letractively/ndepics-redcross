<?php

//************************************
// Summer 2011: Daniel Bolivar (dbolivar@nd.edu)
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// insertCitizenReport.php - This uses PHP to recieve relevant variables from the Citizen version of the mobile app and insert them into the database.
//************************************

include("./config/functions.php");
include("./config/open_database.php");

// This obtains the information from the mobile app or from createCitizenReport.php
$username = $_POST["username"];
$image_bool = $_POST["image_bool"];

// This is coming from createCitizenReport.php and not the mobile app.
if($image_bool == "testing"){
	// A blank file name means that there is no image.
	if($_FILES['image']['name'] == ""){
		$image_bool = 0;
	}
	// There is an image from createCitizenReport.php
	else{
		$image_bool = 1;
		$image_file_name = $_FILES['image']['name'];
		$time_taken = $_POST["time_taken"];
	}
}

// This checks whether there is an image attached with the report.
if($image_bool){
	$image_file_name = $_POST["image_file_name"].".jpg";
	$time_taken = $_POST["time_taken"];
}

$electricity = $_POST["electricity"];
$damage = $_POST["damage"];
$accessible = $_POST["accessible"];

$water_basement = $_POST["water_basement"];
$water_first_floor = $_POST["water_first_floor"];
$water_first_floor_no_basement = $_POST["water_first_floor_no_basement"];
$water_second_floor = $_POST["water_second_floor"];

$water_line_broken = $_POST["water_line_broken"];
$gas_line_broken = $_POST["gas_line_broken"];
$electricity_line_broken = $_POST["electricity_line_broken"];

$name = $_POST["name"];
$street = $_POST["street"];
$city = $_POST["city"];
$county = $_POST["county"];
$state_province = $_POST["state_province"];
$zip_code = $_POST["zip_code"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];

// This inserts the citizen report into the database.
$query = "INSERT INTO rc_citizen_reports (username, image_bool,";
if($image_bool){
	$query = $query."image_file_name, time_taken,";
} 
$query = $query."electricity, damage, accessible, 
			water_basement, water_first_floor, water_first_floor_no_basement, water_second_floor,
			water_line_broken, gas_line_broken, electricity_line_broken,
			name, street, city, county, state_province, zip_code, latitude, longitude, time_received
			)			
			VALUES('$username', '$image_bool',";
if($image_bool){
	$query = $query."'$image_file_name', '$time_taken',";
}
$query = $query."'$electricity', '$damage', '$accessible',
			'$water_basement', '$water_first_floor', '$water_first_floor_no_basement', '$water_second_floor',
			'$water_line_broken', '$gas_line_broken', '$electricity_line_broken',
			'$name', '$street', '$city', '$county', '$state_province', '$zip_code', '$latitude', '$longitude', DATE_ADD(NOW(), INTERVAL 3 HOUR)
			)
			";

$result = mysql_query($query) or die ("Error: Inserting Citizen Report");

// This inserts the citizen report's image into citizen_images
if($image_bool){
	$temp = $_FILES["image"]["tmp_name"];
	$errorCheck = $_FILES["image"]["error"];

	if($errorCheck > 0){
		echo "Error: Citizen Report's Image is invalid";
	}
	else{
		$image_file_dir = "citizen_images/".$image_file_name;
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

$mail_subject = "Citizen Report Submitted";
$mail_message = "
	Your report to St. Joseph County Red Cross Chapter has been submitted.
	Thank you.
	";
$mail_message = wordwrap($mail_message, 70);
$mail_header = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
mail($mail_to, $mail_subject, $mail_message, $mail_header);

// This sends a text message to the submitter.
$smsGatewayEmail = emailToSms($cellPhone, $cellCarrier);
mail($smsGatewayEmail, $mail_subject, $mail_message, $mail_header);

// This re-direct if the report was inserted using the web interface.
session_start();
if($_SESSION["valid"] == "valid"){
	header( 'Location: ./home.php' );
}

include("./config/close_database.php");

?>