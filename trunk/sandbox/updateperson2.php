<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 if( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){
 	header( 'Location: ./index.php' );
 }

include ("config/dbconfig.php");
include ("config/opendb.php");
include_once ("config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst, Mark Pasquier, Bryan Winther, Matt Mooney
//  Fall 2009
//
// updateperson2.php - file to verify the modification to a person record in the disaster database
//****************************

//
// Get the variables from the previous page to be updated in database
$person_id		= $_POST['person_id'];
$salutation		= $_POST['salutation'];
$first_name		= $_POST['first_name'];
$last_name		= $_POST['last_name'];
$street_address = $_POST['street_address'];
$city			= $_POST['city'];
$state			= $_POST['state'];
$zip			= $_POST['zip'];
$home_phone		= $_POST['home_phone_1'].$_POST['home_phone_2'].$_POST['home_phone_3'];
$work_phone		= $_POST['work_phone_1'].$_POST['work_phone_2'].$_POST['work_phone_3'];
$mobile_phone	= $_POST['mobile_phone_1'].$_POST['mobile_phone_2'].$_POST['mobile_phone_3'];
$fax			= $_POST['fax'];
$email			= $_POST['email'];
$im				= $_POST['im'];

$organization_id = $_POST["organization_id"];
$title_in_organization = $_POST["title_in_organization"];
$role_in_organization = $_POST["role_in_organization"];
$organizationremove_id = $_POST["organizationremove_id"];


//
//Query to update organization
$query = "UPDATE	person 
		  SET		salutation = \"".$salutation."\" ,
					first_name = \"".$first_name."\" ,
					last_name = \"".$last_name."\" ,
					street_address = \"".$street_address."\" ,
					city = \"".$city."\" ,
					state = \"".$state."\" ,
					zip = \"".$zip."\" ,
					home_phone = \"".$home_phone."\" ,
					work_phone = \"".$work_phone."\" ,
					mobile_phone = \"".$mobile_phone."\" ,
					fax = \"".$fax."\" ,
					email = \"".$email."\" ,
					im = \"".$im."\" 
		  WHERE		person_id = ".$person_id."
		  LIMIT 1";

$result = mysql_query($query) or die ("Error sending person update query");


if ($organization_id != "NULL") {
	// Query to link resource to the added organization
	$query = "INSERT INTO works_for (person_id, organization_id, title, role) 
			  VALUES (".$person_id.",".$organization_id.",\"".$title_in_organization."\",\"".$role_in_organization."\")";
			  
	$result = mysql_query($query) or die ("Error adding works_for");
}

if(organizationremove_id != "NULL") {
$query = "DELETE	
		  FROM		works_for 
		  WHERE		person_id = ".$person_id."
		  AND		organization_id = ".$organizationremove_id."";
		  
$result = mysql_query($query) or die ("Deletion Query failed, please retry.");
}


//Update Log
$query = "SELECT log FROM person WHERE person_id = ".$person_id;
$result = mysql_query($query) or die ("Person Log Query failed");
$row = mysql_fetch_assoc($result);

//Get Date and Time
$tempdate = date("m/d/Y H:i:s");

$query = "UPDATE person SET log = '" .$_SESSION['username']. ": " .$tempdate. "\n"
		 .$row['log']. "' WHERE person_id = ".$person_id;
$result = mysql_query($query) or die ("Person Log Update failed");


// Redirect back to the organization's information page
$redirect_url = "./personinfo.php?id=".$person_id;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Person Added</title>
<? print "<script type=\"text/javascript\">
			<!-- 
			function redirect(url) {
				window.location = \"".$redirect_url."\" 
			}
			//-->
			</script>"; 
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2009.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<STYLE type="text/css">
 SPAN { padding-left:3px; padding-right:3px }
 DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
 BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
</STYLE>

</head>

<body class="main" onLoad="setTimeout('redirect()', 300)">
<div style="border:2px solid white; background-color:#FFFFFF">
<div align="center" class="header">
<img src="masthead.jpg" style="width:740px; height:100px">
  			<p style="padding-bottom:1px; margin:0">
				American Red Cross, St. Joseph County Chapter
			</p>
			<p style="font-weight:normal; padding:0; margin: 0">
				<span>3220 East Jefferson Boulevard</span>
				<span>&nbsp;</span>
				<span>South Bend</span>
				<span>Indiana</span>
				<span>46615</span>
				<span>Phone (574) 234-0191</span>

			</p>
</div>
<div align="center">
  <h3>Updating Person... Please be patient, you will be redirected shortly.</h3>
</div>

<?

print "<div align='center'>";
print "<form action=\"./home.php\" >\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div>";

include ("config/closedb.php");
?>