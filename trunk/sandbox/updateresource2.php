<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

include ("config/dbconfig.php");
include ("config/opendb.php");
include_once ("config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst, Mark Pasquier, Bryan Winther, Matt Mooney
//  Fall 200
//
// updateresource2.php - file to verify the modification to a resource in the disaster database
//****************************

//
// Get the variables from the previous page to be updated in database
$resource_id	= $_POST["resource_id"];
$resource_type	= $_POST["resource_type"];
$description	= $_POST["resource_description"];
$keyword		= $_POST["resource_keyword"];


//
//Query to update organization
$query = "UPDATE	detailed_resource 
		  SET		resource_type = \"".$resource_type."\" ,
					description = \"".$description."\" ,
					keyword = \"".$keyword."\" 
		  WHERE		resource_id = ".$resource_id."
		  LIMIT 1";

$result = mysql_query($query) or die ("Error sending resource update query");

// Redirect back to the organization's information page
$redirect_url = "./resourceinfo.php?id=".$resource_id;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Organization Added</title>
<? print "<script type=\"text/javascript\">
			<!-- 
			function redirect(url) {
				window.location = \"".$redirect_url."\" 
			}
			//-->
			</script>"; ?>
</head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2009.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">


 <STYLE type="text/css">
  SPAN { padding-left:3px; padding-right:3px }
  DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
  BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
 </STYLE>


<body class="main" onLoad="setTimeout('redirect()', 300)">
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
<c>
  <h3 align="center">Updating Resource... Please be patient, you will be redirected shortly.</h3>
</c>
</div>

<?

print "<div align='center'>";
print "<form action=\"./home.php\" >\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div>";

include ("config/closedb.php");
?>