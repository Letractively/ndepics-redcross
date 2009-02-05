<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
  if( ($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) ){
 	header( 'Location: ./index.php' );
 } 

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addresource1.php - file to insert a resource into the disaster database;
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Welcome to the St. Joseph County Chapter American Red Cross - Disaster Database - Update Information</title>



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

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
  <h1 align="center">Add Resource</h1>

<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</div>

<br><br>			 
<form name='addresource' method='post' action='addresource2.php' align ='left'>
	<input type=hidden name=addtype value=resource>
	<table>
		<tr>
		<td> Type of Resource</td>
		<td><input name='resource_type' type='text' maxlength='30' align= 'left'> </td>
		</tr>

		<tr>
		<td>Description (maximum of 1000 characters)</td>
		<td> <textarea name='resource_description' rows=6 cols=40 align= 'left' valign='top'> </textarea></td>
		</tr>
		
		<tr>
		<td>Keyword(s)</td>
		<td> <input name='resource_keyword' type='text' maxlength='50' align= 'left'> </td>
		</tr>
		
	</table>

	<br>
	<input type=submit>
	<input type=reset>

</form>

<br>
<div align='center'>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</div>

</div>
</body>

</html>

