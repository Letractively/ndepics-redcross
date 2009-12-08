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
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Mike Ellerhorst
//
//  Spring 2009
//
// updateuseraccess.php - admin only page where a given user's access level can be changed.
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
<title>(Admin Only) - Update User's Access Level</title>

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
  <a href = "./updateuser.php" target= "_parent"> UPDATE USER PROFILE</a> |
  <a href = "./search.php" target= "_parent"> SEARCH </a> |
  <a href = "./logout.php" target= "_parent"> LOGOUT </a>
  </div>
</iframe>

<!--<div class="menu">
<a href = "./home.php" > HOME</a> | 
<a href = "./updateuser.php" > UPDATE USER PROFILE</a> |
<a href = "./search.php" > SEARCH </a> |
<a href = "./logout.php" > LOGOUT </a>
</div>-->

<?
//
//	Display the selected user's information and 
//	current access level in pre-populated checkboxes
//

print "User id: ".$_POST['user_id']."<br>";
if( $_POST['user_id'] == "NULL" ){
	print "<center><h3>You must select a user to modify.<br />";
	print "<form action=\"modifyuser.php\" method=\"post\">";
	print "<input type=\"submit\" value=\"Try Again\" />";
	print "</form></h3></center>";
}
else{
	$query = "	SELECT	u.username, u.email, al.*
				FROM	users u, access_level al
				WHERE	u.user_id = ".$_POST['user_id']."
				AND		u.access_level_id = al.access_level_id";
				
	$result = mysql_query($query) or die ("Error: Could not access the selected user's information");
	
	$row = mysql_fetch_assoc($result);
	
	print "<center><h2>".$row['username']."'s Access Rights</h2>";
	print " <h3>An administrative level grants all user abilities listed below.</h3>";
	
	print "<form action=\"updateuseraccess2.php\" method=\"post\">";
	
	print "<input type=\"hidden\" name=\"user_id\" value=".$_POST['user_id'].">";
	
	print "<table align=\"center\">";
	
	print "	<tr>";
	print "	<td><b>Admin</b></td>";
	print " <td><input type=\"checkbox\" name=\"admin\" value=\"1\" ".($row['Admin']?'checked="checked"':'')."></td>";
	print " </tr>";		
	
	print "	<tr>";
	print "	<td><b>Search</b></td>";
	print " <td><input type=\"checkbox\" name=\"search\" value=\"1\" ".($row['Search']?'checked="checked"':'')."></td>";
	print " </tr>";
	
	print "	<tr>";
	print "	<td><b>Insert</b></td>";
	print " <td><input type=\"checkbox\" name=\"insert\" value=\"1\" ".($row['Insert']?'checked="checked"':'')."></td>";
	print " </tr>";
			
	print "	<tr>";
	print "	<td><b>Delete</b></td>";
	print " <td><input type=\"checkbox\" name=\"delete\" value=\"1\" ".($row['Delete']?'checked="checked"':'')."></td>";
	print " </tr>";
			
	print "	<tr>";
	print "	<td><b>Update</b></td>";
	print " <td><input type=\"checkbox\" name=\"update\" value=\"1\" ".($row['Update']?'checked="checked"':'')."></td>";
	print " </tr>";		
	
	print "</table>";
	
	print "<br>";
	
	print "<input type=\"submit\" value=\"Update User\">";
	
	print "</form>";

}

include ("config/closedb.php");
?>

</div>
</body>
</html>
