<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

 if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
 	header( 'Location: ./index.php' );
 }

// ****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// personinfo.php - Page to display information about a given person;
// ****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Personal Information</title>

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
  <div class="menu" align="center">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>


<?php


//IF YOU HAVE ACCESS CODE.....
 if( !(($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0))){
 
		print "<h1 align=\"center\">Personal Information</h1><hr>";
		
		$person_id = $_GET['id'];
		
		//print "Person_id: ".$person_id."<br>";
		
		$query = "SELECT * FROM person WHERE person_id = ".$person_id;
		
		$result = mysql_query($query) or die ("Query Failed...could not retrieve person's information");
		
		$row = mysql_fetch_assoc($result);
		

 //*******
 // Display the Personal Information
  print "<h3>".$row['salutation']." ".$row['first_name']." ".$row['last_name']."</h3>";
  print $row['street_address']."<br>";
  print $row['city'].", ".$row['state']." ".$row['zip']."<br>";
  if($row['county'])
    print "County: ".$row['county']."<br>";
  print "<br>";
  print "Home Phone:  ".print_phone($row['home_phone'])."<br>";
  print "Work Phone:  ".print_phone($row['work_phone'])."<br>";
  print "Mobile Phone:  ".print_phone($row['mobile_phone'])."<br>";
  print "Fax:  ".print_phone($row['fax'])."<br>";
  print "<br>";
  print "Email: <a href=\"mailto:".$row['email']."\">".$row['email']."</a><br>";
  print "IM: ".$row['im']."<br>";
  print "<br>";
  print "Info: ".$row['additional_info']."<br>";
  print "<br>";
  print "Updated by ".$row['updated_by']." on ".$row['updated_time']."<br>";
		

 //***** BUTTONS to Navigate ****/
		print "<div align=\"left\" name=\"navigation_buttons\">";
		
			
		print "<table>";
		print	"<tr>";
		
		
		// Update BUTTON
		if( !(($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./updateperson.php\" method=\"POST\" >";
		print			"<input type=hidden name=person_id value=".$person_id.">";
		print			"<input type=submit value='Update Record'>";
		print			"</form>";
		print		"</td>";
		}
		
		
		// Delete BUTTON
		if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./deleteperson.php\" method=\"POST\" >";
		print			"<input type=hidden name=person_id value=".$person_id.">";
		print			"<input type=submit value='Delete Record'>";
		print			"</form>";
		print		"</td>";
		}
		
		print	"</tr>";
		print "</table>";
		
		print "</div>";
		
		/******/


		mysql_free_result($result);
		
		if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
			print	"<a href=\"./viewlog.php?id=".$person_id."&type=person\">Admin Log</a><br>";
		}

 // Display the organizations that are connected to this person
 print "<center><h2>Associated with these Organizations</h2></center>";
		
 
 // Organization query
 $organization_query = "SELECT	O.* , WF.*
 FROM		organization O JOIN (works_for WF, person P)
 ON		(P.person_id = WF.person_id AND WF.organization_id = O.organization_id )
 AND		P.person_id = ".$person_id;
						
 $result = mysql_query($organization_query) or die ("Organization Query failed");
		
		
// Display the Organization's information
print "<table border='1' align='center'>";
print	"<tr>";
print	"<th>Organization</th>";
print	"<th>Title in Organization</th>";
print	"<th>Role in Organization</th>";
//print	"<th>Address</th>";
//print	"<th>County</td>";
//print	"<th>Business Phone</th>";
print	"<th>Organization's Resources</th>";
print	"</tr>";

while($row = mysql_fetch_assoc($result)) {
print "<tr>";
print	"<td><a href=\"./organizationinfo.php?id=".$row['organization_id']."\">".$row['organization_name']."</td>";
print	"<td>".$row['title']."</td>";
print	"<td>".$row['role']."</td>";
// Get the resources linked to this organization
print	"<td>";
// Resource query
$resource_query = "SELECT	DR.* 
		   FROM		detailed_resource DR JOIN (resource_listing RL, organization O)
		   ON		(DR.resource_id = RL.resource_id AND RL.organization_id = O.organization_id)
		   AND		O.organization_id = ".$row['organization_id'];			  
									  
$resource_result = mysql_query($resource_query) or die ("Resource Query failed");
	
$resource_count = 0;
while($resource_row = mysql_fetch_assoc($resource_result) ) {
	print "<a href=\"./resourceinfo.php?id=".$resource_row['resource_id']."\">".$resource_row['resource_type']."<br>";
	$resource_count++;
}
	if ($resource_count == 0) {
	  print "No associated resources";
	}
	    	
print "</td>";
	
print "</tr>";
}
		
print "</table>";	
mysql_free_result($result);

print "<center><h2>Associated with these Resources</h2></center>";

//Person associated with these resources
$resource_p_q = "SELECT R.*
                 FROM detailed_resource R 
                 JOIN (resource_person RP, person P) 
                 ON (P.person_id = RP.person_id AND RP.resource_id = R.resource_id) 
                 AND P.person_id = ".$person_id;

$result = mysql_query($resource_p_q) or die("Resource-Person query failed");

		//Display resource information
		print "<table border='1' align='center'>";
		print "<tr>";
		print "<th>Resource</th>";
		print "</tr>";
		while($row = mysql_fetch_assoc($result))
		  {
		    print "<tr>";
		    print "<td>".$row['resource_type']."</td>";
		    print "</tr>";
		  }
		print "</table>";

//Add a resource to a person
print "<form action='./resourcetoperson.php' method='POST' >";
print "<input type=hidden name=person_id value='".$person_id."'>";
		print "<input type=submit value='Add a Resource'>";
		print "</form>";
		
		
		print "<div align = 'center'>";
		print "<br><form>";
		print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
		print "</form>";
		print "</div>";
		
		
		
		include ("./config/closedb.php");
 }

//IF YOU ONLY HAVE INSERT PRIVELEDGES
else{

	print 	"<div align=\"center\">";
	print 	"<h2>Person Successfully Added.";
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
