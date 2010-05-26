<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addorganization2.php - file to insert an organization into the disaster database
//****************************
session_start();
// Validate the users's session
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
echo "<title>St. Joseph Red Cross - Add Organization</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");


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
$updated_by = $_POST["updated_by"];
$from_res_seq = $_POST["from_res_seq"];
$addresfromorg = 2;

 if($from_res_seq){
  $business_phone = $_POST["business_phone"];
  $business_phone2 = $_POST["business_phone2"];
  $business_fax = $_POST["business_fax"];
 }


// Scrub the inputs
$organization_name = scrub_input($organization_name);
$street_address = scrub_input($street_address);
$mailing_address = scrub_input($mailing_address);
$city = scrub_input($city);
$state = scrub_input($state);
$county = scrub_input($county);
$email = scrub_input($email);
$website = scrub_input($website);
$addtl_info = scrub_input($addtl_info);
$updated_by = scrub_input($updated_by);

print "<p align=center><b>Please add a resource for this organization.</b></p>";

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
        print "<td><b>Your Initials</b></td>";
        print "<td>".$updated_by."</td>";
        print "</tr>";

        
print "</table>";

print "<br><br>";

print "<form name='verifyorganization' method='post' action='addorganization3.php' align='left'>";
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
print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";

print "<div align = 'center'>";
print "Select a Resource: ";
  
$query = "Select * from detailed_resource ";
$query .= "ORDER BY resource_type";

$result = mysql_query($query) or die("Could not access resources");

if( mysql_num_rows($result) < 1 )
{
        print "There are no resources to be added, please go back and add a resource first!<br>";
}
else 
{
        print "<select name=\"resource_id\" onchange=\"showResource(this.value)\">";
        print "<option value=\"NULL\"> </option>";
        
        while( $row = mysql_fetch_assoc($result) )
        {
                print "<option value=\"".$row['resource_id']."\">".$row['resource_type']."</option>";
        }
        
        print "</select>";
}

print "<br> or add a new resource by clicking button below";

print "<br><br><input type=submit value='Continue'>";
print "</form>";

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
print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
print "<input type=hidden name='addresfromorg' value='2'>";
print "<br><input type=submit value='Add New Resource'>";
print "</form>";


print "</div>";

print "<p>";
print "<div id=\"txtHint\"><b>Resource info will be listed here.</b></div>";
print "</p>";

print "<br></div>";
print "</div>";

print "</div>";
print "</body>";
print "</html>";


include ("config/closedb.php");
include("html_include_3.php");
?>
