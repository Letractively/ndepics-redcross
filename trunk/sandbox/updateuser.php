<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
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
// updateuser.php - File to allow the user to change the password or 
//					email address that is associated with the account.
//
// Revision History:  Created - 02/10/09
//
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include_once ("./config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Update User Profile</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
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
<a href = "./home.php"> HOME</a> | 
<a href = "./search.php"> SEARCH </a>
</div>-->

<?
 // 
 //Form to collect new user info
 
	 $query = "	SELECT	*
				FROM	users
				WHERE	user_id = ".$_SESSION['user_id']."
				LIMIT	1";

	$result = mysql_query($query) or die("Error: Query retrieving user info");
	$row = mysql_fetch_assoc($result);
	
	$username	= $row['username'];
	$email		= $row['email'];
?>

<center><h3><? echo $username; ?>'s User Profile</h3>

<form name="updateuser" method="post" action="updateuser2.php" align ="left">

	<table align="center">
		<tr>
		<td>Old Password</td>
		<td><input name="oldpassword" type="password" maxlength="15" align="left"> </td>
		</tr>
		
		<tr>
		<td>New Password</td>
		<td><input name="newpassword" type="password" maxlength="15" align="left"> </td>
		</tr>
		
		<tr>
		<td>Verify New Password</td>
		<td><input name="verify_pass" type="password" maxlength="15" align="left"> </td>
		</tr>

		<tr>
		<td>Email</td>
		<td><input name="email" type="text" maxlength="50" align="left" value="<? echo $email; ?>" > </td>
		</tr>
	</table>

	<br>
	<center>
	<input type=submit value="Update User">
	<input type=reset value="Clear Form">

</form>


</body>
</html>
