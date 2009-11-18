<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

 if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
 	header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// organizationinfo.php - Page to display information about a given organization;
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Organization Information</title>
</head>

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
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<?php
//IF YOU HAVE SEARCH RIGHTS
 if( !(($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0))){
 
		print "<h1 align=\"center\">Organization Information</h1><hr>";
		
		$organization_id = $_GET['id'];
		
		//print "Org_id: ".$organization_id."<br>";
		
		$query = "SELECT * FROM organization WHERE organization_id = ".$organization_id;
		
		$result = mysql_query($query) or die ("Query Failed...could not retrieve organization information");
		
		$row = mysql_fetch_assoc($result);

  $querys = "SELECT * FROM statement_of_understanding WHERE organization_id = ".$organization_id;

                $results = mysql_query($querys) or die ("Query Failed...could not retrieve organization information");
 
                $rows = mysql_fetch_assoc($results);
		
	
		//
		// Display the Organization Information
		print "<h3>".$row['organization_name']."</h3>";
		print $row['street_address']."<br>";
		if($row['mailing_address'])
		  print $row['mailing_address']."<br>";
		print $row['city'].", ".$row['state']." ".$row['zip']."<br>";
		print $row['county']."<br>";
		print "Business Phone:  ".print_phone($row['business_phone'])."<br>";
		print "24H/2nd  Phone:  ".print_phone($row['24_hour_phone'])."<br>";
		print "Business Fax: ".print_phone($row['business_fax'])."<br>";
		print "Email: <a href=\"mailto:".$row['email']."\">".$row['email']."</a><br>";
		print "Website: <a href=\"".$row['website']."\">".$row['website']."</a><br>";
                print "Info: ".$row['additional_info']."<br>";
		print "Updated by ".$row['updated_by']." on ".$row['updated_time']."<br>";
                print "Statement of Understanding: " .$rows['date_of_contract'];
		print $rows['statement_of_understanding'];
		

		// Navigation Buttons
		print "<table>";
		print "<tr>";

		// sou BUTTON
		if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./viewstatementofunderstanding.php\"  method=\"POST\">";
		print			"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
		print			"<input type=\"submit\" value=\"View Statement of Understanding\">";
		print			"</form>";
		print		"</td>";
		}
		
		// facility survey BUTTON
		if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./viewfacilitysurvey.php\"  method=\"POST\">";
		print			"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
		print			"<input type=\"submit\" value=\"View Facility Survey\">";
		print			"</form>";
		print		"</td>";
		}

		print      "</tr>";
		print      "<tr>";
		
		// Update BUTTON
		if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./updateorganization.php\"  method=\"POST\">";
		print			"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
		print			"<input type=\"submit\" value=\"Update Record\">";
		print			"</form>";
		print		"</td>";
		}
		
		// Delete BUTTON
		if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./deleteorganization.php\" method=\"POST\">";
		print			"<input type=hidden name=organization_id value=".$organization_id.">";
		print			"<input type=submit value=\"Delete Record\">";
		print			"</form>";
		print		"</td>";
                }

		print	 "</tr>";
		print "</table>";	

		mysql_free_result($result);

		if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		  print	"<a href=\"./viewlog.php?id=".$organization_id."&type=organization\">Admin Log</a><br>";
		}		
		
		print "<center><h2>Resources</h2></center>";
		
		//
		// Resource query
		$rsrcquery = "SELECT	DR.* 
					  FROM		detailed_resource DR JOIN (resource_listing RL, organization O)
					  ON		(DR.resource_id = RL.resource_id AND RL.organization_id = O.organization_id)
					  AND		O.organization_id = ".$organization_id;
					  
		$result = mysql_query($rsrcquery) or die ("Resource Query failed");
		
		//
			// Display the resource information
			print "<table border='1' align='center'>";
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
		print "<center><h2>People Associated with the Organization</h2></center>";
		
		//
		// Resource query
		$person_query = "SELECT		P.* , WF.*
						 FROM		person P JOIN (works_for WF, organization O)
						 ON			(P.person_id = WF.person_id AND WF.organization_id = O.organization_id )
						 AND		O.organization_id = ".$organization_id;
						  
		$result = mysql_query($person_query) or die ("Person Query failed");
		
		//
		// Display the person's information
			print "<table border='1' align='center'>";
			print	"<tr>";
			print	"<th>Name</th>";
			print	"<th>Address</th>";
			print	"<th>Home Phone</th>";
			print	"<th>Work Phone</th>";
			print	"<th>Mobile Phone</th>";
			print	"<th>Title in Organization</th>";
			print	"<th>Role for Organization</th>";
			print	"</tr>";
		
		while($row = mysql_fetch_assoc($result)) {
		
			print "<tr>";
			print	"<td><a href=\"./personinfo.php?id=".$row['person_id']."\">".$row['salutation']." ".$row['first_name']." ".$row['last_name']."</td>";
			print	"<td>".$row['street_address'];
			print		"<br>".$row['city'].", ".$row['state']."  ".$row['zip']."</td>";
			print	"<td>".print_phone($row['home_phone'])."</td>";
			print	"<td>".print_phone($row['work_phone'])."</td>";
			print	"<td>".print_phone($row['mobile_phone'])."</td>";
			print	"<td>".$row['title']."</td>";
			print   "<td>".$row['role']."</td>";
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
?>

<p>
<p>
</div>
</body>
</html>
