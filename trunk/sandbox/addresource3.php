<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addresource3.php - file to insert a resource into the disaster database
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){ //ensure user has "add" rights
	header( 'Location: ./index.php' ); //redirect if not authorized
}  
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Add Resource</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Add Resource</h1>";

//Pick up POSTed variables from addresource2.php
$resource_type = $_POST["resource_type"];
$resource_description = $_POST["resource_description"];
$resource_keyword = $_POST["resource_keyword"];
$addresfromorg = $_POST["addresfromorg"];

//If the variable is set, then this sequence was called by addorganization2.php
if($addresfromorg){
	//So pick up POSTed variables from add organization sequence
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
	$unit = $_POST["unit"];
	$updated_by = $_POST["updated_by"];
}

//check to see is resource exists
$res_query = "SELECT * FROM detailed_resource WHERE resource_type = '".$resource_type." ' ";
$result3 = mysql_query($res_query) or die ("Error checking if resrouce exists query");
$num_rows = mysql_num_rows($result3);
if ($num_rows != 0){
	print "<div align='center'><br />";
	print "Cannot Add Resource Type: \"<b>".$resource_type."</b>\" already exists <br /><br />";
	if($addresfromorg){ //if resource marker is set, we need to forward variables back to add organization sequence
		print "<form action=\"./addorganization2.php\" method ='post'>\n";
		print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
		print "<input type=hidden name='street_address' value=\"".$street_address."\">";
		print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
		print "<input type=hidden name='city' value=\"".$city."\">";
		print "<input type=hidden name='state' value=\"".$state."\">";
		print "<input type=hidden name='zip' value=".$zip.">";
		print "<input type=hidden name='county' value=\"".$county."\">";
		print "<input type=hidden name='business_phone' value='".$business_phone."'>";
		print "<input type=hidden name='business_phone2' value='".$business_phone2."'>";
		print "<input type=hidden name='business_fax' value='".$business_fax."'>";
		print "<input type=hidden name='email' value=\"".$email."\">";
		print "<input type=hidden name='website' value=\"".$website."\">";
		print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
		print "<input type=hidden name='unit' value=\"".$unit."\">";
		print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
		print "<input type=hidden name='from_res_seq' value='2'>";
		print "<button type=\"submit\">Return to Add Organization</button>";
		print "</form>\n";
		print "</div>";
	} else {
        print "<form action=\"./home.php\" >\n";
        print "<button type=\"submit\">Return Home</button>";
        print "</form>\n";
        print "</div>";
        
	}
	include ("config/closedb.php");
	include("html_include_3.php");
    exit(-1);	
} 
//No problem, so continue adding the resource
$tempdate = date("m/d/Y H:i:s");
$query = "INSERT INTO detailed_resource (resource_type, description, keyword, log)
				 VALUES (\"".$resource_type."\",\"".$resource_description."\",\"".$resource_keyword."\",\"".$_SESSION['username'].": " .$tempdate. "\n"
		 .$row['log']."\")";
$result = mysql_query($query) or die ("MySQL Error adding resource to database");

//Print a friendly message to user
print "<h2>Added Resource: </h2>";
print "<table>";
	print "<tr>";
	print "<td width=120><b> Resource Type: </b></td>";
	print "<td>".$resource_type."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td valign=\"top\"><b>Description: </b></td>";
	print "<td width=620>".$resource_description."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Keywords: </b></td>";
	print "<td>".$resource_keyword."</td>";
	print "</tr>";
print "</table><br />";

print "<div align='center'>";
if($addresfromorg){ //if the marker is set, forward existing variables to addorganization2.php forward as hidden inputs
	print "<form action=\"./addorganization2.php\" method ='post'>\n";
	print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
	print "<input type=hidden name='street_address' value=\"".$street_address."\">";
	print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
	print "<input type=hidden name='city' value=\"".$city."\">";
	print "<input type=hidden name='state' value=\"".$state."\">";
	print "<input type=hidden name='zip' value=".$zip.">";
	print "<input type=hidden name='county' value=\"".$county."\">";
	print "<input type=hidden name='business_phone' value='".$business_phone."'>";
	print "<input type=hidden name='business_phone2' value='".$business_phone2."'>";
	print "<input type=hidden name='business_fax' value='".$business_fax."'>";
	print "<input type=hidden name='email' value=\"".$email."\">";
	print "<input type=hidden name='website' value=\"".$website."\">";
	print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
	print "<input type=hidden name='unit' value=\"".$unit."\">";
	print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
	print "<input type=hidden name='from_res_seq' value='2'>";
	print "<button type=\"submit\">Return to Add Organization</button>";
	print "</form>\n";
	print "</div>";
} else { //simple add resource was executed
	print "<form action=\"./home.php\" >\n";
	print "<button type=\"submit\">Return Home</button>";
	print "</form>\n";
	print "</div>";
}

include ("config/closedb.php"); //close connection to database
include("html_include_3.php"); //close HTML tags
?>