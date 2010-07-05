<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2009 - Matt Mooney
// Fall 2010 - Joey Rich
// Summer 2010 - Matt Mooney
// organizationinfo.php - Page to display information about an organization
//****************************
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
	header( 'Location: ./index.php' );
}

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Organization Info</title>";
include("html_include_2.php");

//IF YOU HAVE SEARCH RIGHTS
if( !(($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0))){
	$organization_id = $_GET['id'];
	//print "Org_id: ".$organization_id."<br>";
	$query = "SELECT * FROM organization WHERE organization_id = ".$organization_id;
	$result = mysql_query($query) or die ("Query Failed...could not retrieve organization information");
	$row = mysql_fetch_assoc($result);
	$querysou = "SELECT * FROM statement_of_understanding WHERE organization_id = ".$organization_id;
	$resultsou = mysql_query($querysou) or die ("Query Failed...could not retrieve SOU information");
	$rowsou = mysql_fetch_assoc($resultsou);
	$sou_date = substr($rowsou['date_of_contract'],5,2) . "/" . substr($rowsou['date_of_contract'],8,2) . "/" . substr($rowsou['date_of_contract'],0,4);
	$queryfs = "SELECT * FROM facility_survey WHERE organization_id = ".$organization_id;
	$resultfs = mysql_query($queryfs) or die ("Query Failed...could not retrieve FS information");
	$rowfs = mysql_fetch_assoc($resultfs);
	$fs_date = substr($rowfs['date_completed'],5,2) . "/" . substr($rowfs['date_completed'],8,2) . "/" . substr($rowfs['date_completed'],0,4);
	$querysi = "SELECT * FROM shelter_info WHERE organization_id = ".$organization_id;
	$resultsi = mysql_query($querysi) or die ("Wuery Failed...could not retreive shelter_info information");
	$rowsi = mysql_fetch_assoc($resultsi);
			
	print "<h1 style=\"display: inline\">Organization Information";
	print "</h1><br/><hr>";

	// Display the Organization Title
	print "<h3>".$row['organization_name']."</h3>";
	
	//Display the Google Map
	$google_addr = str_replace(' ','+',$row['street_address'].",".$row['city'].",".$row['state']);
	print "<img src='http://maps.google.com/maps/api/staticmap?&markers=size:mid|color:red|"
	.$google_addr."&zoom=15&size=300x300&sensor=false' alt='Map' align='right'>";
	
	//Display the Organization Information
	if($row['street_address'] != "NULL")
		print $row['street_address']." (Street Address)<br>";
	if($row['mailing_address'] != "NULL")
		print $row['mailing_address']." (Mailing Address)<br>";
	print $row['city'].", ".$row['state']." ".$row['zip']."<br>";
	print $row['county']."<br><br>";
	print "Business Phone: ".print_phone($row['business_phone'])."<br>";
	print "24-Hour Phone:  ".print_phone($row['24_hour_phone'])."<br>";
	print "Business Fax: ".print_phone($row['business_fax'])."<br>";
	print "Email: <a href=\"mailto:".$row['email']."\">".$row['email']."</a><br>";
	print "Website: <a href='http://".$row['website']."'>".$row['website']."</a><br><br>";
	print "Additional Information: ".$row['additional_info']."<br><br>";
	print "Associated with: ".$row['association']."<br><br>";
	
	$display_date = substr($row['updated_time'],5,2) . "/" . substr($row['updated_time'],8,2) . "/" . substr($row['updated_time'],0,4);
	print "Updated by ".$row['updated_by']." on ".$display_date."<br><br>";
	
		//Shelter Information if needed
	if($rowsi['organization_id'] != ""){
		print "Shelter Information:<br>";
		print "Size: ".$rowsi['size']."<br>";
		print "Capacity: ".$rowsi['capacity']."<br>";
		print "Entered in to National DB on".$rowsi['nat_entry_date']."<br><br>";
	}
	else
		print "No Shelter Information.<br>";
		
		//SoU
	if($rowsou['filename'] != ""){
		print "Statement of Understanding uploaded on: " .$sou_date."&nbsp;&nbsp;";
		if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
			print "<form action=\"./viewstatementofunderstanding.php\"  method=\"POST\">";
			print 	"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
			print 	"<input type=\"submit\" value=\"View Statement of Understanding\">";
			print "</form>";
			print "<br>";
		}
	}
	else
		print "No Statement of Understanding<br>";
		
		//FS
	if($rowfs['filename'] != ""){
		print "Facility Survey uploaded on: " .$fs_date."&nbsp;&nbsp;";
		if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
			print "<form action=\"./viewfacilitysurvey.php\"  method=\"POST\">";
			print	"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
			print	"<input type=\"submit\" value=\"View Facility Survey\">";
			print "</form>";
			print "<br>";
		}
	}
	else
		print "No Facility Survey<br>";
	
	// Navigation Buttons
	print "<div align=\"left\" name=\"navigation_buttons\">";
	print "<table cellpadding=0 cellspacing=0>";
	print	"<tr>";
	// Update BUTTON
	if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
	{
		print		"<td width=\"50%\" align=\"left\">";
		print		"<form action=\"./updateorganization.php\"  method=\"POST\">";
		print			"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
		print			"<input type=\"submit\" value=\"Update Record\">";
		print			"</form>";
		print		"</td>";
	}
	// Delete BUTTON
	if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
	{
		print		"<td>";
		print		"<form action=\"./deleteorganization.php\" method=\"POST\">";
		print			"<input type=hidden name=organization_id value=".$organization_id.">";
		print			"<input type=submit value=\"Delete Record\">";
		print			"</form>";
		print		"</td>";
		print		"</tr>";
	}

	print "</table>";
	print "</div>";
	
	mysql_free_result($result);
	
	if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
	{
		print	"<a href=\"./viewlog.php?id=".$organization_id."&type=organization\">Admin Log</a><br>";
	}
	
	print "<br/><br/><h2 style=\"display: inline\">Resources</h2><br/>";
	
	//
	// Resource query
	$rsrcquery = "SELECT	DR.* 
				  FROM		detailed_resource DR JOIN (resource_listing RL, organization O)
				  ON		(DR.resource_id = RL.resource_id AND RL.organization_id = O.organization_id)
				  AND		O.organization_id = ".$organization_id;
				  
	$result = mysql_query($rsrcquery) or die ("Resource Query failed");
	
	//
		// Display the resource information
		print "<table class=\"std_table\" cellpadding=0 cellspacing=0>";
		print	"<tr>";
		print	"<th>Type of Resource</th>";
		print	"<th>Description</th>";
		print	"<th>Keyword(s)</th>";
		print	"</tr>";
	
	while($row = mysql_fetch_assoc($result)) {
	
		print "<tr>";
		print	"<td><a href=\"./resourceinfo.php?id=".$row['resource_id']."\">".$row['resource_type']."</td>";
		print	"<td>".$row['description']."</td>";
		print	"<td>".$row['keyword']."</td>";
		print "</tr>";
	}
	
	print "</table>";
		
	mysql_free_result($result);
	
	
	//
	// Display the people that are connected to an organization
	print "<br/><h2 style=\"display: inline\">Associated People</h2><br/>";
	
	//
	// Resource query
	$person_query = "SELECT		P.* , WF.*
					 FROM		person P JOIN (works_for WF, organization O)
					 ON			(P.person_id = WF.person_id AND WF.organization_id = O.organization_id )
					 AND		O.organization_id = ".$organization_id;
					  
	$result = mysql_query($person_query) or die ("Person Query failed");
	
	//
	// Display the person's information
		print "<table class=\"std_table\" cellpadding=0 cellspacing=0>";
		print	"<tr>";
		print	"<th>Name</th>";
		print	"<th>Address</th>";
		print	"<th>Home&nbsp;Phone</th>";
		print	"<th>Work&nbsp;Phone</th>";
		print	"<th>Mobile&nbsp;Phone</th>";
		print	"<th>Title</th>";
		print	"<th>Role</th>";
		//print"<th>Update Information</th>";
		print	"</tr>";
	
	while($row = mysql_fetch_assoc($result)) {
	
		print "<tr>";
		print	"<td><a href=\"./personinfo.php?id=".$row['person_id']."\">".$row['salutation']."&nbsp;".$row['first_name']."&nbsp;".$row['last_name']."</td>";
		print	"<td>".$row['street_address'];
		print		"<br>".$row['city'].", ".$row['state']."  ".$row['zip']."</td>";
		print	"<td>".print_phone($row['home_phone'])."</td>";
		print	"<td>".print_phone($row['work_phone'])."</td>";
		print	"<td>".print_phone($row['mobile_phone'])."</td>";
		print	"<td>".$row['title']."</td>";
		print   "<td>".$row['role']."</td>";

				// Update BUTTON
		   if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		   {
				   print		"<!--<td width=\"50%\" align=\"center\"><form action=\"./updateperson.php\"  method=\"POST\">";
				   print			"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
				   print			"<input type=\"submit\" value=\"Update Role\">";
				   print			"</form>";
				   print		"</td>-->";
		   }
		print "</tr>";
	}
	
		print "</table>";
		
	mysql_free_result($result);
	
	print "<div align = 'center'>";
	print "<br><form>";
	print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
	print "</form>";
	print "</div>";
	
	include ("./config/closedb.php");
}
else{

	print 	"<div align=\"center\">";
	print 	"<h2>Organization Successfully Added.";
	print 	"<p>Thank You. </h2>";
	print		"<td><form action=\"./home.php\">";
	print			"<input type=submit value='Home'>";
	print			"</form>";
	print		"</td>";
	print	"</div";
}
include("html_include_3.php");
?>
