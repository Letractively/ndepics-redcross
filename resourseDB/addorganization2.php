<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// addorganization2.php - file to insert an organization into the disaster database
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
echo "<title>St. Joseph Red Cross - Add Organization</title>"; //print page title
echo "<script src=\"./javascript/selectresource.js\"></script>"; //import script for displaying resource information
include("html_include_2.php"); //rest of HTML header info

//collect variable POSTed from addorganization.php
$organization_name = $_POST["organization_name"];
$street_address = $_POST["street_address"];
$mailing_address = $_POST["mailing_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$county = $_POST["county"];
$business_phone = $_POST["bus_phone_1"].$_POST["bus_phone_2"].$_POST["bus_phone_3"];
$business_phone2 = $_POST["bus_phone2_1"].$_POST["bus_phone2_2"].$_POST["bus_phone2_3"];
$business_fax = $_POST["bus_fax_1"].$_POST["bus_fax_2"].$_POST["bus_fax_3"];
$email = $_POST["email"];
$website = $_POST["website"];
$addtl_info = $_POST["addtl_info"];
$unit = $_POST["unit"];
//$updated_by = $_POST["updated_by"];
$nss_id = $_POST["nss_id"];
$from_res_seq = $_POST["from_res_seq"];
$addresfromorg = 2;

//if collecting varables from addresrouce3.php, then take phone numbers in full form
if($from_res_seq){
	$business_phone = $_POST["business_phone"];
	$business_phone2 = $_POST["business_phone2"];
	$business_fax = $_POST["business_fax"];
}


// Scrub the inputs, see functions.php for more information
$organization_name = scrub_input($organization_name);
$street_address = scrub_input($street_address);
$mailing_address = scrub_input($mailing_address);
$city = scrub_input($city);
$state = scrub_input($state);
$county = scrub_input($county);
$email = scrub_input($email);
$website = scrub_input($website);
$addtl_info = scrub_input($addtl_info);
$unit = scrub_input($unit);
//$updated_by = scrub_input($updated_by);
$nss_id = scrub_input($nss_id);
print "<p align=center><b>Please add a resource for this organization.</b></p>";
//print the existing information about the organization in an organized table:
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
        print "<td><b>Additional Info</b></td>";
        print "<td>".$addtl_info."</td>";
        print "</tr>";
		
        print "<tr>";
        print "<td><b>Red Cross Unit(s): </b></td>";
        print "<td>".$unit."</td>";
        print "</tr>";
          
        print "<tr>";
        print "<td><b>NSS ID/Code</b></td>";
        print "<td>".$nss_id."</td>";
        print "</tr>";
print "</table>";
print "<br />";

//Forward all of the inputs as hidden form inputs
print "<form name='addorganization2' method='post' action='addorganization3.php' align='left'>";
print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
print "<input type=hidden name='street_address' value=\"".$street_address."\">";
print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
print "<input type=hidden name='city' value=\"".$city."\">";
print "<input type=hidden name='state' value=\"".$state."\">";
print "<input type=hidden name='zip' value=".$zip.">";
print "<input type=hidden name='county' value=\"".$county."\">";
print "<input type=hidden name='business_phone' value=".$business_phone.">";
print "<input type=hidden name='business_phone2' value=".$business_phone2.">";
print "<input type=hidden name='business_fax' value=".$business_fax.">";
print "<input type=hidden name='email' value=\"".$email."\">";
print "<input type=hidden name='website' value=\"".$website."\">";
print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
print "<input type=hidden name='unit' value=\"".$unit."\">";
print "<input type=hidden name='nss_id' value=\"".$nss_id."\">";

//div where Javascript with display resource information
print "<div id=\"txtHint\"><b>Resource info will be listed here.</b></div>";
print "<br />";

//Now we select a resource to associate with  the organization
print "<div align = 'center'>";
print "Select a Resource: ";

//Query the database to get a list of existing resources
$query = "Select * from detailed_resource ";
$query .= "ORDER BY resource_type";
$result = mysql_query($query) or die("Could not access resources");
if( mysql_num_rows($result) < 1 ) {
	print "There are no resources to be added, please go back and add a resource first!<br />";
} else {
	print "<select name=\"resource_id\" onchange=\"showResource(this.value)\">"; //use a select/dropdown input for the resource
	print "<option value=\"NULL\"> </option>";
	while( $row = mysql_fetch_assoc($result) ) {
		print "<option value=\"".$row['resource_id']."\">".$row['resource_type']."</option>"; //print each resource as an option
	}
	print "</select>"; //end the select/dropdown input
}
print "<br /> or add a new resource by clicking button below";
print "<br /><br /><input type=submit value='Continue'>"; //submit the hidden inputs and resource to addorganization3.pgp
print "</form>";

//Forward the inputs as hidden values forward to the addresource1.php page to add a new resource
print "<form name='addresourcefromorganization' method='post' action='addresource1.php' align='center'>";
print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
print "<input type=hidden name='street_address' value=\"".$street_address."\">";
print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
print "<input type=hidden name='city' value=\"".$city."\">";
print "<input type=hidden name='state' value=\"".$state."\">";
print "<input type=hidden name='zip' value=".$zip.">";
print "<input type=hidden name='county' value=\"".$county."\">";
print "<input type=hidden name='business_phone' value=".$business_phone.">";
print "<input type=hidden name='business_phone2' value=".$business_phone2.">";
print "<input type=hidden name='business_fax' value=".$business_fax.">";
print "<input type=hidden name='email' value=\"".$email."\">";
print "<input type=hidden name='website' value=\"".$website."\">";
print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
print "<input type=hidden name='unit' value=\"".$unit."\">";
print "<input type=hidden name='nss_id' value=\"".$nss_id."\">";
print "<input type=hidden name='addresfromorg' value='2'>";
print "<br /><input type=submit value='Add New Resource'>";
print "</form>";

print "</div>";
print "</div>";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
