<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// deleteresource2.php - deletes the designated resource;
//****************************

include ("config/dbconfig.php");
include ("config/opendb.php");
include ("config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<title>Disaster Database - Delete Organization</title>
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


<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">
<div align="center" class="header">
<c>
<img src="masthead.jpg" style="width:740px; height:100px">
  			<p style="padding-bottom:1px; margin:0">
				American Red Cross, St. Joseph County Chapter
			</p>
			<p style="font-weight:normal; padding:0; margin: 0">
				<span>3220 East Jefferson Boulevard</span>
				<span>&nbsp;</span>
				<span>South Bend</span>
				<span>Indiana</span>
				<span>46615</span>
				<span>Phone (574) 234-0191</span>

			</p>
</c>
</div>
<div align="center">
  <h1>Delete Organization</h1>
</div>


<?php
//
// Get and display the resource information

$organization_id = $_POST['organization_id'];

$query = "DELETE	
		  FROM		organization
		  WHERE		organization_id = ".$organization_id."
		  LIMIT		1";
		  
$result = mysql_query($query) or die ("Deletion Query failed");

$query = "DELETE	
		  FROM		works_for
		  WHERE		organization_id = ".$organization_id;
		  
$result = mysql_query($query) or die ("Deletion Query 2 failed");

$query = "DELETE	
		  FROM		resource_listing
		  WHERE		organization_id = ".$organization_id;
		  
$result = mysql_query($query) or die ("Deletion Query 3 failed");

print "<center><h2>Organization Deleted Successfully</h2></center>";

print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div><br>";

include ("config/closedb.php");

?>


</div>
</body>
</html>