<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
// Make sure the user is an admin
 if($_SESSION['access_level_id'] != 9) {
        header( 'Location: ./index.php' );
 } 

//****************************
//  Developed by ND Epics for St. Joe County Red Cross 
//  
// Authors: Mike Ellerhorst 
//  Spring 2009
//
// deleteuser.php - admin only page that deletes a user and redirects home or displays error message
//
// Revision History:  02/24/09 - Created
//
//****************************

include ("config/dbconfig.php");
include ("config/opendb.php");
include ("config/functions.php");

//
// Delete the user passed from the previous page and if successful, redirect home.
//	Else, display error message and give option to go home or back.

$redirect_url = "./home.php";

$user_id	= $_POST['user_id'];

$search		= $_POST['search'];
$insert		= $_POST['insert'];
$update		= $_POST['update'];
$delete		= $_POST['delete'];
$admin		= $_POST['admin'];

// Set the access level based on the the checkbox values
$access_level = 0;

if($admin == 1) {	$access_level = 9;	}
else {
	if ($search == 1) {
		if ($insert == 1) { $access_level += 4; }
		if ($update == 1) { $access_level += 1; }
		if ($delete == 1) { $access_level += 2; }

		// Only search allowed
		if ($access_level == 0) { $access_level = 10; }
	}
	else {
		// Only insert allowed
		if ($insert == 1) { $access_level = 8; }
		
	}
}

$query = "UPDATE	users
		  SET		access_level_id = ".$access_level."
		  WHERE		user_id = ".$user_id."
		  LIMIT		1";
		  
$result = mysql_query($query);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>(Admin Only) - Delete User</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<? if($result) {
	print "<meta http-equiv=\"Refresh\" content=\"0.01; url=".$redirect_url."\">"; 
   }
?>
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
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
  <h1>Update Person</h1>
</div>


<?php

//'
// Error Deleting user
// 

print "<center><h2>There was an error updating the user's access privileges. Please try again.</h2></center>";

print "Query was: \"".$query."\"";
print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<input type=\"submit\" value=\"Return Home\">";
print "</form>\n";

print "<form>\n";
print "<input type=\"button\" value=\"Back\" onClick=\"window.location.href='javascript:history.back()'\">";
print "</form>\n";
print "</div><br>";

include ("config/closedb.php");

?>


</div>
</body>
</html>