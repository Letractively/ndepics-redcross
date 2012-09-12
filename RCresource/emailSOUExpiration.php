<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2012 - Henry Kim
// emailSOUExpiration.php - send an e-mail if the SOU nears the expiration date.
//****************************
$noStatement = array();
$noExpiration = array();

// This creates a multi-dimensional array about SoU that are about to expire.
$name = array();
$date = array();
$soonExpire = array($name, $date);

$alreadyExpire = array();

// This goes through all the organizations in the database.
$query = "SELECT * FROM organization";
$result = mysql_query($query) or die(mysql_error()); 
while($organization = mysql_fetch_array($result)){
	// There is no SoU document.
	if($organization["statement_understanding"] == NULL){
		array_push($noStatement, $organization["organization_name"]);
	}
	// There is no SoU expiration date.
	else if($organization["statement_expiration"] == "0000-00-00"){
		array_push($noExpiration, $organization["organization_name"]);
	}
	else{
		// This obtains the current date and converts the time to Unix timestamp (the number of seconds since January 1 1970 00:00:00 UTC).
		$todayDate = date("Y-m-d");
		$todayUnixTime = strtotime($todayDate);
		$expirationUnixTime = strtotime($organization["statement_expiration"]); 
		
		$thirtyDaysInSeconds = 2592000;
		
		// The SoU has expired.
		if($expirationUnixTime < $todayUnixTime){
			array_push($alreadyExpire, $organization["organization_name"]);
		}
		// The SoU will expire in about two months.
		else if( ($expirationUnixTime < $todayUnixTime + $thirtyDaysInSeconds*2)){
			array_push($soonExpire, (array_push($soonExpire[0], $organization["organization_name"])));
			array_push($soonExpire, (array_push($soonExpire[1], $organization["statement_expiration"])));
		}
		// The SoU will expire in about a month.
		else if( ($expirationUnixTime < $todayUnixTime + $thirtyDaysInSeconds)){
			array_push($soonExpire, (array_push($soonExpire[0], $organization["organization_name"])));
			array_push($soonExpire, (array_push($soonExpire[1], $organization["statement_expiration"])));
		}
	}
}

// This sends out an e-mail with relevant information about the SoU and its expiration date to all the users.
$mail_subject = "Disaster Resources Database - Statement of Understanding";
$mail_message = "St. Joseph County Chapter of the American Red Cross\n";
$mail_message = $mail_message."\n";

$limit = count($soonExpire[0]);
for($i=0; $i < $limit; $i++){
	$mail_message = $mail_message."Your Statement of Understanding with ".$soonExpire[0][$i]." will expire on ".$soonExpire[1][$i].". Please reaffirm this contact and update information as appropriate.\n";
}
$mail_message = $mail_message."\n";

$limit = count($alreadyExpire);
for($i=0; $i < $limit; $i++){
	$mail_message = $mail_message."Your Statement of Understanding with ".$alreadyExpire[$i]." has expired and this resource has been archived.\n";
}
$mail_message = $mail_message."\n";

$mail_message = $mail_message."Please include the documentation about the Statement of Understanding with the following organization(s).\n";
$limit = count($noStatement);
for($i=0; $i < $limit; $i++){
	$mail_message = $mail_message.$noStatement[$i]."\n";
}
$mail_message = $mail_message."\n";

$mail_message = $mail_message."Please include the expiration date about the Statement of Understanding with the following organization(s).\n";
$limit = count($noExpiration);
for($i=0; $i < $limit; $i++){
	$mail_message = $mail_message.$noExpiration[$i]."\n";
}
$mail_message = $mail_message."\n";

$query2 = "SELECT * FROM users WHERE access_level_id = '9'";
$result2 = mysql_query($query2) or die(mysql_error()); 	
while($personArr = mysql_fetch_array( $result2)){
	$mail_to = $personArr['email'];
	mail($mail_to, $mail_subject, $mail_message, $mail_header);
}

?>