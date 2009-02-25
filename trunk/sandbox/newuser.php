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
// newuser.php - File to show the input boxes to create a new user.
//
// Revision History:  02/04/09 - Created 
//					  02/24/09 - Updated menus and made password generation random.
//
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Create a New User</title>

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
 //' 
 //Form to collect user information
?>

<form name="newuser" method="post" action="newuser2.php" align ="left">

	<table>
		<tr>
		<td>Username</td>
		<td><input name="username" type="text" maxlength="50" align="left"> </td>
		</tr>

		<tr>
		<td>Email</td>
		<td><input name="email" type="text" maxlength="50" align="left"> </td>
		</tr>
	</table>
	
	<table>
		<tr>
		<td><b>User Capabilities</b></td>
		</tr>
		
		<tr>
		<td>Admin</td>
		<td><input name="admin" type="checkbox" value="1"></td>
		<td>An administrative level grants all user abilities listed below.</td>
		</tr>
		
		<tr>
		<td>Search</td>
		<td><input name="search" type="checkbox" value="1"></td>
		</tr>
		
		<tr>
		<td>Insert</td>
		<td><input name="insert" type="checkbox" value="1"></td>
		</tr>
		
		<tr>
		<td>Delete</td>
		<td><input name="delete" type="checkbox" value="1"></td>
		</tr>
		
		<tr>
		<td>Update</td>
		<td><input name="update" type="checkbox" value="1"></td>
		</tr>
		
	</table>

	<br>
	<input type="submit" value="Create New User">
	<input type="reset" value="Clear Form">

</form>


</body>
</html>
