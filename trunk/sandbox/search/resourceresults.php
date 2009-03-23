<?php

error_reporting(E_ALL);

ini_set ('display_errors', '1');

session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./../index.php' );
}

include ("./../config/dbconfig.php");
include ("./../config/opendb.php");
include ("./../config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// organizationsearch.php - the search results page;
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Search Results</title>

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

<iframe src ="../homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<?php
print "<center><h2>Search Results</h2></center>";
print "<hr>";

print "<div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "</div>";

//Search type
$search_type = $_POST['search_type'];

//print "Search type is: ".$search_type."<br>";


if ($search_type == "resource") {
	print "<h3><center>Searching based on Resource</center></h3>";

	$search = scrub_search($_POST['keyword_resource_search']);
	$query = '';
	$and = 0;
	
	$resource_id = $_POST['resource_id'];
	
	$query =	  "SELECT	*
				  FROM		organization O 
				  JOIN		(resource_listing RL, detailed_resource DR)
				  ON		(DR.resource_id = RL.resource_id AND RL.organization_id = O.organization_id)";
	
	if($resource_id != "NULL") {
	
		$resource_query = "SELECT	resource_type
						   FROM		detailed_resource
						   WHERE	resource_id = ".$resource_id;
						   
		$resource_result = mysql_query($resource_query) or die ("Couldn't get resource name");
		$resource_row = mysql_fetch_assoc($resource_result);
		
		print "Searching for organizations with the resource: ".$resource_row['resource_type']."<br>";
		$and = 1;
		$query .=	" AND (RL.resource_id = ".$resource_id;
	}
	
	if($search != '') {
		print "Searching for organizations with the resource: \"".$search."\"<br>";
		$matchterms = "resource_type, description, keyword";
		
		if($and) {
			$query .= " OR	MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
		}
		else {
			$query .= " AND MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
		}
	}
	
	if($and) { $query .= ")"; }
							
	$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");
	$num_results = 0;
	
	print "<table>";
	print "<tr>";
		print "<td align=left valign=top width=\"50%\">";
		print "<td align=left valign=top width=\"50%\">";
	print "</tr>";
	
	while ( $row = mysql_fetch_assoc($result) ) {
		$num_results += 1;
	 
		print "<tr>";
		print "<td>";
		print "<b><a href=\"../organizationinfo.php?id=".$row['organization_id']."\">".
			   $row['organization_name']."</a></b><br>".
			   $row['street_address']."<br>".
			   $row['city'].", ".$row['state']." ".$row['zip']."<br>".
			   $row['county']." County<br>
			   Ph:  ".print_phone($row['business_phone'])."<br>
			   Fax: ".print_phone($row['business_fax'])."<br>";
		print "</td>";
			   
			   
		//
		// Display resources associated with the organization
		$resource_query = "SELECT	*
						   FROM		detailed_resource DR
						   JOIN		(resource_listing RL, organization O) 
						   ON		(O.organization_id = RL.organization_id AND RL.resource_id = DR.resource_id)
						   AND		O.organization_id = ".$row['organization_id'];
							  
		$resource_result = mysql_query($resource_query) 
							or die ("Couldn't retrieve resources for ".$row['organization_name'].". Please try again.");
	
		print "<td>";
		print "<b>Available Resources:</b><br>";
		$resources = 0;
		while( $resource_row = mysql_fetch_assoc($resource_result) ) {
			$resources += 1;
			print $resource_row['resource_type']."<br>";
		}
		if ($resources == 0) {
			print "No available resources.<br>";
		}
		print "</td>";
	print "</tr>";
	
	}
	
	if ($num_results == 0) {
		print "<br> Sorry, your search did not return any matching organizations.<br>";
	}
} 

print "</table>";
			
print "<br><div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "<br></div>";
			   	   

include ("./../config/closedb.php");

?>

</div>
</body>
</html>