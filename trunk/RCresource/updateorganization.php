<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2009 - Matt Mooney
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// updateorganization.php - file to update an organization's information within the database
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
//Determine if user has update rights
if( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){
	header( 'Location: ./index.php' ); //redirect if not authorized
} 
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Update Organization</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
?>
<div align="center">
  <h1>Update Organization</h1>
</div>
<?
// Retrieve the requested organizations information
$organization_id = $_POST["organization_id"];

$query = "SELECT        *
			FROM          organization
			WHERE         organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Organization Query failed");
$row = mysql_fetch_assoc($result);

//Set variables
$organization_name = $row['organization_name'];
$street_address = $row['street_address'];
$mailing_address = $row['mailing_address'];
$city = $row['city'];
$state = $row['state'];
$zip = $row['zip'];
$county = $row['county'];
$business_phone = $row['business_phone'];
$business_phone2 = $row['24_hour_phone'];
$business_fax = $row['business_fax'];
$email = $row['email'];
$website = $row['website'];
$additional_info = $row['additional_info'];
$unit = $row['association'];

print "<center><form name='updateorganization' method='post' action='updateorganization2.php'>\n";
print "<p align=center><b>Change the desired fields and press 'Update Organization'.</b></p>\n";
print "<input name='organization_id' type='hidden' value='".$organization_id."'>\n";

//  Provide input fields pre-populated with the existing values in the database
print "<table>\n";
print "<tr>\n";
print "<td><b>Organization Name: </b></td>\n";
print "<td><input name='organization_name' type='text' maxlength='50' align= 'left' value=\"".$organization_name."\"></td>\n";
print "</tr>\n";
 
print "<tr>\n";
print "<td><b>Street Address: </b></td>\n";
print "<td><input name='street_address' type='text' maxlength='50' align= 'left' value=\"".$street_address."\"></td>\n";
print "</tr>\n";

print "<tr>\n";
print "<td><b>Mailing Address: </b></td>\n";
print "<td><input name='mailing_address' type='text' maxlength='50' align= 'left' value=\"".$mailing_address."\"></td>\n";
print "</tr>\n";

print "<tr>\n";
print "<td><b>City: </b></td>\n";
print "<td><input name='city' type='text' maxlength='30' align= 'left' value=\"".$city."\"></td>\n";
print "</tr>\n";

print "<tr>\n";
print "<td><b>State: </b></td>\n";
print "<td><input name='state' type='text' size='2' maxlength='2' align= 'left' value=\"".$state."\"></td>\n";
print "</tr>\n";
 
print "<tr>\n";
print "<td><b>Zip:</b></td>\n";
print "<td><input name='zip' type='text' size='5' maxlength='5' align= 'left' value=\"".$zip."\"></td>\n";
print "</tr>\n";

print "<tr>\n";
print "<td><b>County: </b></td>\n";
print "<td><input name='county' type='text' maxlength='20' align= 'left' value=\"".$county."\"></td>\n";
print "</tr>\n";
 
print "<tr>\n";
print "<td><b>Business Phone: </b></td>\n";
print "<td>(<input name='bus_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($business_phone,0,3)."'>)&nbsp\n";
print "         <input name='bus_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($business_phone,3,3)."'>&nbsp - &nbsp\n";
print "         <input name='bus_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($business_phone,6,4)."'>\n";
print "</td>\n";
print "</tr>\n";
 
print "<tr>\n";
print "<td><b>24-Hour Phone: </b></td>\n";
print "<td>(<input name='bus_phone2_1' type='number' size='3' maxlength='3' align='left' value='".substr($business_phone2,0,3)."'>)&nbsp\n";
print "         <input name='bus_phone2_2' type='number' size='3' maxlength='3' align='left' value='".substr($business_phone2,3,3)."'>&nbsp - &nbsp\n";
print "         <input name='bus_phone2_3' type='number' size='4' maxlength='4' align='left' value='".substr($business_phone2,6,4)."'>\n";
print "</td>\n";
print "</tr>\n";

print "<tr>\n";
print "<td><b>Business Fax: </b></td>\n";
print "<td>(<input name='bus_fax_1' type='number' size='3' maxlength='3' align='left' value='".substr($business_fax,0,3)."'>)&nbsp\n";
print "         <input name='bus_fax_2' type='number' size='3' maxlength='3' align='left' value='".substr($business_fax,3,3)."'>&nbsp - &nbsp\n";
print "         <input name='bus_fax_3' type='number' size='4' maxlength='4' align='left' value='".substr($business_fax,6,4)."'>\n";
print "</td>\n";
print "</tr>\n";
 
print "<tr>\n";
print "<td><b>Email: </b></td>\n";
print "<td><input name='email' type='text' maxlength='50' align= 'left' value=\"".$email."\"></td>\n";
print "</tr>\n";
 
print "<tr>\n";
print "<td><b>Website</b></td>\n";
print "<td><input name='website' type='text' maxlength='100' align= 'left' value=\"".$website."\"></td>\n";
print "</tr>\n";
 
 print "<tr>\n";
 print "<td><b>Additional Info: </b></td>\n";
 print "<td><textarea name='additional_info' rows=6 cols=40 align='left'>".$additional_info."</textarea></td>\n";
 print "</tr>\n";
 
 print "<tr>\n";
 print "<td valign='top'><b>Red Cross Associations:</b><br /><i>Check all that apply</i></td>\n";
 
 //Logic to pre-check boxes for associations
 $check = array();
 $unitarray= array();
 // Collect data from "chapters" table.
 $chapters_data = mysql_query("SELECT * FROM chapters") or die("Error: Getting Chapters");
 while($chapters = mysql_fetch_array($chapters_data)){
 	array_push($unitarray, $chapters[chapter_name]);
 }
 // Collect data from "districts" table.
 $districts_data = mysql_query("SELECT * FROM districts") or die("Error: Getting Districts");
 while($districts = mysql_fetch_array($districts_data)){
 	array_push($unitarray, $districts[district_name]);
 }
 array_push($unitarray, "Region","State","National","Other");

 $unitarray = array_values($unitarray);
 
 $unit = "STR:".$unit;
  for($i=0;$i<count($unitarray);$i++)
 {	
 	if(strpos($unit,$unitarray[$i]) > 0) {
 		$check[$i] = "checked=\"checked\"";
	}
 	else {
 		$check[$i] = "";
	}
 }
 
        	// Collect data from "chapters" table.
			$chapters_data = mysql_query("SELECT * FROM chapters") or die("Error: Getting Chapters");
			print "<tr>";
			print '<td valign="top"><b>Associate to a Red Cross Unit:<br /><i>Check all that apply</i></b></td>';
			print "<td>";
			
			// This keeps track of the number of units.
			$countActual = -1;
			
			print "Chapters:";
			// This fetches all the chapters and displays four chapters for each line.
			$countChapters = -5;
			while($chapters = mysql_fetch_array($chapters_data)){
				$countChapters = $countChapters + 1;
				$countActual = $countActual + 1;
				if($countChapters % 4 == 0 and $countChapters >= 0){
        			print "<br />";
        			print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";					
				}
				print '<input type="checkbox" name="unit[]"'.$check[$countActual].'value="'.$chapters[chapter_name].'" />'.$chapters[chapter_name];
			}
			print "<br />";
			
			$districts_data = mysql_query("SELECT * FROM districts") or die("Error: Getting Districts");
			print "Districts:";
			$countDistricts = -5;
			// This fetches all the districts and displays four districts for each line.
			while($districts = mysql_fetch_array($districts_data)){
				$countDistricts = $countDistricts + 1;
				$countActual = $countActual + 1;
				if($countDistricts % 4 == 0 and $countDistricts >= 0){
					print "<br />";
					print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
				}
				print '<input type="checkbox" name="unit[]"'.$check[$countActual].'value="'.$districts[district_name].'" />'.$districts[district_name];
			}
			print "<br />";
?>
        <? $countActual = $countActual + 1; ?>
        <input type="checkbox" name="unit[]" <? echo $check[$countActual]; ?> value="Region" />Region
        <br />
        <? $countActual = $countActual + 1; ?>
        <input type="checkbox" name="unit[]" <? echo $check[$countActual]; ?> value="State" />State
        <br />
        <? $countActual = $countActual + 1; ?>
        <input type="checkbox" name="unit[]" <? echo $check[$countActual]; ?> value="National" />National
        <br />
        <? $countActual = $countActual + 1; ?>
        <input type="checkbox" name="unit[]" <? echo $check[$countActual]; ?> value="Other" />Other
        </td>
 <?
print "</tr>\n";

//Add a resource
print "<tr>\n";
print "<td><b>Add a Resource</b></td>\n";
print "<td>";
	$query = "SELECT		dr.* 
				FROM		detailed_resource dr
				WHERE		NOT EXISTS (
								SELECT  rl.*
								FROM    resource_listing rl 
								WHERE	rl.resource_id = dr.resource_id
								AND	rl.organization_id = ".$organization_id.")
				ORDER BY 	dr.resource_type";
	 $result = mysql_query($query) or die("Could not access resources");
	
	if( mysql_num_rows($result) < 1 )
	{
		print "There are no resources to be added, please go back and add a resource first!<br />";
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
	
	print "&nbsp&nbsp or &nbsp&nbsp";
	print "<INPUT TYPE=\"BUTTON\" VALUE=\"Add New Resource\"ONCLICK=\"window.location.href='./addresource1.php'\">";
print "</td>";
print "</tr>\n";

//Remove a resource
print "<tr>\n";
print "<td><b>Remove Resource: </b></td>\n";
print "<td>";
$query = "SELECT	dr.* 
			FROM		detailed_resource dr
			WHERE		 EXISTS (
							SELECT  rl.*
							FROM    resource_listing rl 
							WHERE	rl.resource_id = dr.resource_id
							AND	rl.organization_id = ".$organization_id.")";
$result = mysql_query($query) or die("Could not access resources");
 
print "<select name=\"resourceremove_id\" onchange=\"showResource(this.value)\">";
print "<option value=\"NULL\"> </option>";
 
while( $row = mysql_fetch_assoc($result) )
  {
    print "<option value=\"".$row['resource_id']."\">".$row['resource_type']."</option>";
  }
print "</select>";
print "</td>";
print "</tr>\n";

print "</table>\n";

print "<div align = 'center'>\n";
print "<br /><input type='submit' value='Update Organization'>";
print"</form>";

print "<br /><br />";

//Additional buttons for external table updating
print"<form action=\"./shelter.php\"  method=\"POST\">";
print"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
print"<input type=\"submit\" value=\"Update Shelter Information\">";
print"</form>";

print"<form action=\"./sou.php\"  method=\"POST\">";
print"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
print"<input type=\"submit\" value=\"Upload Statement of Understanding\">";
print"</form>";

print"<form action=\"./facilitysurvey.php\"  method=\"POST\">";
print"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
print"<input type=\"submit\" value=\"Upload Facility Survey\">";
print"</form>";
 
print "<br />\n";
print "<form>\n";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">\n";
print "</form>\n";
print "<br /></div>\n";
print "</div>\n";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>