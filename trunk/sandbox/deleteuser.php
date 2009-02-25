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
// Authors: Mike Ellerhorst & Mark Pasquier
//  Spring 2009
//
// deleteuser.php - admin only page that verifies that a user should be deleted;
//
// Revision History:  02/24/09 - Created
//
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("./config/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>(Admin Only) Update User</title>
<script src="./javascript/selectuser.js"></script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2009.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<!-- <link rel="stylesheet" type="text/css" href="/custom.css"/> -->
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
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<!--<div class="menu">
<a href = "./home.php" > HOME</a> | 
<a href = "./updateuser.php" > UPDATE USER PROFILE</a> |
<a href = "./search.php" > SEARCH </a> |
<a href = "./logout.php" > LOGOUT </a>
</div>-->

<?

// '
// Get the names of all users other than the current one and populate a dropdown
//	The user's info will be displayed and the option to update access levels
//	or delete the user will be displayed.
//

print "<center><h2>Select User to Change: </h2>";
print "<form name=\"select_user\" action=\"deleteuser2.php\" method=\"post\">\n";
print "<select name=\"user_id\" onchange=\"showUser(this.value)\">";
  
$query = "SELECT * FROM users WHERE user_id != ".$_SESSION['user_id'];

$result = mysql_query($query) or die("Could not get other users");

if( mysql_num_rows($result) < 1 )
{
	print "There are no other users in the database except you!<br>";
}
else 
{
	print "<option value=\"NULL\"> </option>";
	
	while( $row = mysql_fetch_assoc($result) )
	{
		$uid = $row['user_id'];
		$uname = $row['username'];
		print "<option value=\"".$uid."\">".$uname."</option>";
	}
}

print "</select>";

print "<p>";
print "<div align=\"center\" id=\"txtHint\"><b>User info will be listed here.</b></div>";
print "</p>";

print "Are you sure you want to delete this user?<br>";
print "	<input type=\"submit\" value=\"Delete User\">";

print "</form>";




include ("config/closedb.php");

?>


</div>
</body>
</html>