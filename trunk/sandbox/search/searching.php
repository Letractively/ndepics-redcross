<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ../index.php' );
 }
 
  if( ($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0)){
 	header( 'Location: ../index.php' );
 } 

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// searching.php - page that is never seen that sets session variables and redirects to correct search results page
//
// Revision History: 3/24/09	Mike Ellerhorst - Created file.
//
//****************************


// Set the search type and text SESSION variables.  Then set the corresponding url to be redirected to.

$_SESSION['search_type'] = $_POST['search_type'];
if($_SESSION['search_type'] == '') {
	$redirect_url = "../search.php";
}

if($_SESSION['search_type'] == "general") {
	$_SESSION['search_text'] = $_POST['search_text'];
	$redirect_url = "./generalresults.php";

}
elseif ($_SESSION['search_type'] == "organization") {
	$_SESSION['search_text'] = $_POST['search_text'];
	$redirect_url = "./orgresults.php";
	
}
elseif ($_SESSION['search_type'] == "detailed_organization") {
	$_SESSION['search_text'] = '';
	$_SESSION['detailed_search_name']	= $_POST['detailed_search_name'];
	$_SESSION['detailed_search_city']	= $_POST['detailed_search_city'];
	$_SESSION['detailed_search_state']	= $_POST['detailed_search_state'];
	$_SESSION['detailed_search_zip']	= $_POST['detailed_search_zip'];
	$_SESSION['detailed_search_county']	= $_POST['detailed_search_county'];
	
	$redirect_url = "./orgresults.php";

}
elseif ($_SESSION['search_type'] == "resource") {
	$_SESSION['search_text'] = $_POST['search_text'];
	$_SESSION['resource_id'] = $_POST['resource_id'];
	$redirect_url = "./resourceresults.php";

}
elseif ($_SESSION['search_type'] == "resource_city") {
	$_SESSION['search_text'] = $_POST['search_text'];
	$_SESSION['search_city'] = $_POST['search_city'];
	$_SESSION['search_zip']  = $_POST['search_zip'];
	$_SESSION['resource_id'] = $_POST['resource_id'];
	$redirect_url = "./resourcecityresults.php";

}
elseif ($_SESSION['search_type'] == "person") {
	$_SESSION['search_text'] = $_POST['search_text'];
	$redirect_url = "./personresults.php";

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Searching ... </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved."><link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico"><link rel="stylesheet" type="text/css" href="/style.css"/><? print "<meta http-equiv=\"Refresh\" content=\"0.09; url=".$redirect_url."\">"; ?></head><body class="main">	<div style="border:0px; background-color: #fff; padding: 0px">		<div align="center" class="header">			<img src="/masthead.jpg" style="width: 740px; height: 100px">		</div>				<div style="background-color: #000; padding: 5px; margin: 0px; color: #fff; height: 40px">			<div style="float: left;">				<b>American Red Cross, St. Joseph County Chapter</b><br/>				3220 East Jefferson Boulevard, South Bend IN 46615			</div>						<div style="float: right;">				<b>Phone: (574) 234-0191</b><br/>				<a class="whitelink" href="http://disaster.stjoe-redcross.org">http://disaster.stjoe-redcross.org</a>			</div>		</div>		<table style="padding: 0px; margin: 0px; border: 0px;" cellpadding=0 cellspacing=0>		<tr>		<td style="background-color: #222; width: 740px; border: 0px">		<? echo html_navmenu() ?>		</td>		</tr>		<tr>		<td style="padding: 10px; width: 100%; vertical-align: top; border: 0px">
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

<iframe src ="../homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<?
//'
// Display a "searching ..." page. User will be redirected after 1 second.
//

print "<center><h1>Searching...</h1>\n";
print "<br><br>\n";
print "<h3> If you are not redirected shortly, please try your search again.</h3>\n";

?>

</td></tr></table>
</body>
</html>
