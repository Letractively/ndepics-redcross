<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addorganization3.php - file to insert an organization into the disaster database
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
} 
include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Organization Added</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");
?>

<div align="center">
  <h1>Add Organization</h1>
</div>

<?
// Get the variables from the previous page
$organization_name = $_POST["organization_name"];
$street_address = $_POST["street_address"];
$mailing_address = $_POST["mailing_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$county = $_POST["county"];
$business_phone = $_POST["business_phone"];
$business_phone2 = $_POST["business_phone2"];
$business_fax = $_POST["business_fax"];
$email = $_POST["email"];
$website = $_POST["website"];
$addtl_info = $_POST["addtl_info"];
$updated_by = $_POST["updated_by"];
$resource_id = $_POST["resource_id"];

//Query to check if organization already exists
$org_query = "SELECT * FROM organization WHERE organization_name = '".$organization_name." ' ";

$result3 = mysql_query($org_query) or die ("Error checking if organization exists query");

$num_rows = mysql_num_rows($result3);

if ($num_rows != 0){
       print "<div align='center'><br>";
       print "Cannot Add Organization: \"<b>".$organization_name."</b>\" already exists <br><br>";
       print "<form action=\"./home.php\" >\n";
       print "<button type=\"submit\">Return Home</button>";
       print "</form>\n";
       print "</div>";
       exit(-1);
}
else{
     // print "Organization " .$organization_name." does not exist";
}

// Get the next auto_increment value (organization id)
$query = "SHOW TABLE STATUS LIKE 'organization'";
$result = mysql_query($query) or die ("Error sending table status query");
$row = mysql_fetch_assoc($result);
$organization_id = $row['Auto_increment'];

//Query to add organization
$tempdate = date("m/d/Y H:i");
$query = "INSERT INTO  organization (organization_name ,
				     street_address ,
                     mailing_address ,
				     city ,
				     state ,
				     zip ,
				     county ,
				     business_phone ,
                     24_hour_phone ,
				     business_fax ,
				     email ,
				     website ,
                     additional_info , 
                     updated_by ,
					 updated_time ,
                     log)
		 VALUES (\"".$organization_name."\",
                         \"".$street_address."\",
                         \"".$mailing_address."\",
                         \"".$city."\",
                         \"".$state."\",
                         \"".$zip."\",
                         \"".$county."\",
                         \"".$business_phone."\",
                         \"".$business_phone2."\",
                         \"".$business_fax."\",
                         \"".$email."\",
                         \"".$website."\",
                         \"".$addtl_info."\",
                         \"".$updated_by."\",
						 NOW(),
                         \"".$tempdate.": ".$updated_by." authenticated as ".$_SESSION['username']."\n".$row['log']."\")";
 $result = mysql_query($query) or die("Error adding Orgnaization");


// Make sure the organization id is correct
$org_query = "SELECT * FROM organization WHERE organization_id = ".$organization_id;
$result2 = mysql_query($org_query) or die ("Error checking the Organization ID");
$row = mysql_fetch_assoc($result2);
if($row['organization_name'] != $organization_name) {
	print "Organization names do not match up! Exiting...<br>\n";
       //Display what values are being added to the database

print "<h2><font color = \"red\">Failed to Add Values: </font></h2>";
print "<table>";
	print "<tr>";
	print "<td><b>Organization Name: </b></td>";
	print "<td>".$organization_name."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Street Address: </b></td>";
	print "<td>".$street_address."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Mailing Address: </b></td>";
	print "<td>".$mailing_address."</td>";
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
	print "<td><b>Zip:</b></td>";
	print "<td>".$zip."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>County: </b></td>";
	print "<td>".$county."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Business Phone: </b></td>";
	print "<td>";
	echo print_phone($business_phone);
	print "</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>24H or 2nd Phone: </b></td>";
	print "<td>";
	echo print_phone($business_phone2);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Business Fax: </b></td>";
	print "<td>";
	echo print_phone($business_fax);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Email: </b></td>";
	print "<td>".$email."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Website</b></td>";
	print "<td>".$website."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Info</b></td>";
	print "<td>".$addtl_info."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Initials</b></td>";
	print "<td>".$updated_by."</td>";
	print "</tr>";
	
print "</table><br>";
	$org_query = "DELETE FROM organization WHERE organization_name = \"".$organization_name."\"";
	mysql_query($org_query);
	exit (-1);
	//$redirect_url = "./home.php";
}
else {
	$redirect_url = "./organizationinfo.php?id=".$row['organization_id']."\"";
    $message .= "Successful Add...redirecting<br>";
    print "Successfull Add...redirecting to information page";
    print "<meta http-equiv=\"Refresh\" content=\"1.5; url=".$redirect_url."\">";
}

// Query to link resource to the added organization
if($resource_id != "NULL"){
	$query = "INSERT INTO resource_listing (resource_id, organization_id) 
			  VALUES (".$resource_id.",".$organization_id.")";
			  
	$result = mysql_query($query) or die ("Error adding resource_listing");

	print "<div align='center'>";
	print "Organization Successfully Added...Redirecting<br>";
	print "<form action=\"./home.php\" >\n";
	print "<button type=\"submit\">Return Home</button>";
	print "</form>\n";
	print "</div>";
}
else{
	print "<div align='center'>";
	print "Organization Successfully Added With NO RESOURCES...Redirecting<br>";
	print "<form action=\"./home.php\" >\n";
	print "<button type=\"submit\">Return Home</button>";
	print "</form>\n";
	print "</div>";
}

include ("config/closedb.php");
include("html_include_3.php");
?>