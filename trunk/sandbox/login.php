<?php
session_start();

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// login.php - checks the login information and redirects based on success or not.
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");

$username = stripslashes($_POST['username']);
$password = stripslashes($_POST['password']);

scrub_input($username);
scrub_input($password);

$message = "Username: ".$username."  Password: ".$password."<br>";

$query = "SELECT	user_id, access_level_id
		  FROM		users
		  WHERE		username = \"".$username."\"
		  AND		passwd = \"".md5($password)."\"";
	
//print "Query: ".$query."<br>";	  

$result = mysql_query($query) or die ("Unable to access username/password query");

$row = mysql_fetch_assoc($result);


if($row > 1) {

	$message .= "Successful login...setting Session Variables<br>";
	$_SESSION['valid'] = "valid";
	$_SESSION['user_id'] = $row['user_id'];
	$_SESSION['access_level_id'] = $row['access_level_id'];
	$redirect_url = "./home.php";
	
}
else {
	$_SESSION['valid'] = "invalid";
	$redirect_url = "./index.php";
}

mysql_free_result($result);
include ("./config/closedb.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Logging in</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<? print "<meta http-equiv=\"Refresh\" content=\"0.01; url=".$redirect_url."\">"; ?>
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

<body class="main" onLoad="setTimeout('redirect()', 100)">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a> |
  <a href = "./logout.php" target= "_parent"> LOGOUT </a>
  </div>
</iframe>



<div align="center">
<h3> Logging in...you will be redirected shortly.</h3>

	
</div>
</body>

</html>
