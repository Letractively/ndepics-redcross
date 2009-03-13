<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
} 
//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addperson3.php - file that inserts a person into the disaster database;
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include_once ("./config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<title>Disaster Database - Person Added</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<STYLE type="text/css">
 SPAN { padding-left:3px; padding-right:3px }
 DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
 BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
</STYLE>

</head>

<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph\'s County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
  <h1>Add Person</h1>
</div>

<?php
//
// Get the variables from the previous page
$salutation = $_POST["salutation"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$street_address = $_POST["street_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$home_phone = $_POST["home_phone_1"].$_POST["home_phone_2"].$_POST["home_phone_3"];
$work_phone = $_POST["work_phone_1"].$_POST["work_phone_2"].$_POST["work_phone_3"];
$mobile_phone = $_POST["mobile_phone_1"].$_POST["mobile_phone_2"].$_POST["mobile_phone_3"];
$fax = $_POST["fax_1"].$_POST["fax_2"].$_POST["fax_3"];
$email = $_POST["email"];
$im = $_POST["im"];

$organization_id = $_POST["organization_id"];
$title_in_organization = $_POST["title_in_organization"];
$role_in_organization = $_POST["role_in_organization"];


// Scrub the inputs
$salutation = scrub_input($salutation);
$first_name = scrub_input($first_name);
$last_name = scrub_input($last_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$email = scrub_input($email);
$im = scrub_input($im);
$title_in_organization = scrub_input($title_in_organization);
$role_in_organization = scrub_input($role_in_organization);

//
//Query to check if person already exists
$pers_query = "SELECT * FROM person WHERE first_name = '".$first_name." ' AND last_name= '".$last_name."'";

$result3 = mysql_query($pers_query) or die ("Error checking if organization exists query");

$num_rows = mysql_num_rows($result3);

if ($num_rows != 0){
       print "<div align='center'><br>";
       print "Cannot Add Person: \"<b>".$first_name." ".$last_name."</b>\" already exists <br><br>";
       print "<form action=\"./home.php\" >\n";
       print "<button type=\"submit\">Return Home</button>";
       print "</form>\n";
       print "</div>";
       exit(-1);
}
else{
     // print "Organization " .$organization_name." does not exist";
}

//
// Get the next auto_increment value (person id)
$query = "SHOW TABLE STATUS LIKE 'person'";
$result = mysql_query($query) or die ("Error sending table status query");
$row = mysql_fetch_assoc($result);
$person_id = $row['Auto_increment'];

//
//Query to be executed
$query = "INSERT INTO  person (salutation ,
							   first_name ,
							   last_name ,
							   street_address ,
							   city ,
							   state ,
							   zip ,
							   home_phone ,
							   work_phone ,
							   fax ,
							   email ,
							   im )
		 VALUES (\"".$salutation."\",\"".$first_name."\",\"".$last_name."\",\"".$street_address."\",\"".$city."\",\"".
					 $state."\",\"".$zip."\",\"".$home_phone."\",\"".$work_phone."\",\"".$fax."\",\"".$email."\",\"".
					 $im."\")";


$result = mysql_query($query) or die ("Error sending query");


//
// Make sure the person id is correct
$org_query = "SELECT * FROM person WHERE person_id = ".$person_id;
$result2 = mysql_query($org_query) or die ("Error checking the Organization ID");
$row = mysql_fetch_assoc($result2);
if( ($row['first_name'] != $first_name) && ($row['last_name'] != $last_name) ) {
	//print "Person names do not match up! Exiting...<br>\n";
	print "<h2>Person Failed to be Added: </h2>";
	print "<table>";
	print "<tr>";
	print "<td><b>Salutation: </b></td>";
	print "<td>".$salutation."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>First Name: </b></td>";
	print "<td>".$first_name."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Last Name: </b></td>";
	print "<td>".$last_name."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Street Address: </b></td>";
	print "<td>".$street_address."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>City: </b></td>";
	print "<td>".$city."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>State: </b></td>";
	print "<td>".$state."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Zip: </b></td>";
	print "<td>".$zip."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Home Phone: </b></td>";
	print "<td>";
	echo print_phone($home_phone);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Work Phone: </b></td>";
	print "<td>";
	echo print_phone($work_phone);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Fax: </b></td>";
	print "<td>";
	echo print_phone($fax);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Email: </b></td>";
	print "<td>".$email."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>IM: </b></td>";
	print "<td>".$im."</td>";
	print "</tr>";
	
print "</table>";
	$org_query = "DELETE FROM person WHERE person_id = ".$person_id;
	mysql_query($org_query);
	exit (-1);
}
else {
	//print "Person names match up. Successfully added the person<br>\n";

print "<h2>Person Successfully Added: </h2>";
	print "<table>";
	print "<tr>";
	print "<td><b>Salutation: </b></td>";
	print "<td>".$salutation."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>First Name: </b></td>";
	print "<td>".$first_name."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Last Name: </b></td>";
	print "<td>".$last_name."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Street Address: </b></td>";
	print "<td>".$street_address."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>City: </b></td>";
	print "<td>".$city."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>State: </b></td>";
	print "<td>".$state."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Zip: </b></td>";
	print "<td>".$zip."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Home Phone: </b></td>";
	print "<td>";
	echo print_phone($home_phone);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Work Phone: </b></td>";
	print "<td>";
	echo print_phone($work_phone);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Fax: </b></td>";
	print "<td>";
	echo print_phone($fax);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Email: </b></td>";
	print "<td>".$email."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>IM: </b></td>";
	print "<td>".$im."</td>";
	print "</tr>";
	
print "</table>";
}


//
// Query to link resource to the added organization
$query = "INSERT INTO works_for (person_id, organization_id, title, role) 
		  VALUES (".$person_id.",".$organization_id.",\"".$title_in_organization."\",\"".$role_in_organization."\")";
		  
$result = mysql_query($query) or die ("Error adding works_for");


//print "<br> Got to the end of the script <br>";

print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<input type=\"submit\" value=\"Return Home\" >";
print "</form></div><br>\n";


include ("config/closedb.php");
?>

</div>
</body>
</html>
