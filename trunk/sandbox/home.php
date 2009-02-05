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
// home.php - the main entry page for the Disaster Database;
//
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Welcome to the Disaster Database for the St. Joseph County Red Cross</title>



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

<!--<div class="menu">
<a href = "http://disaster.stjoe-redcross.org/sandbox/home.php"> HOME</a> | 
<a href = "http://disaster.stjoe-redcross.org/sandbox/search.php"> SEARCH </a>
</div>-->

<div align="center">
  <h1>Welcome to the Disaster Database for the St. Joseph County Red Cross</h1>
</div>


<p align="center">Please select what you would like to do</p>

<h2 align="center">Input Information</h2>

<div align="center">
  <table>
    <tr>
    <td>
	    <form action="addorganization.php" >
	    <input type="submit" value="Add an organization">
	    </form>
    </td>
    
<td>
	    <form action="addresource1.php" >
	    <input type="submit" value="Add a Resource">
	    </form>
    </td>
    
<td>
	    <form action="addperson.php" >
	    <input type="submit" value="Add a Person">
	    </form>
    </td>
    </tr>
  </table>
  <center>
</div>


<h2 align="center">Search Records</h2>
<form action="search.php" >
  <div align="center">
    <input type="submit" value="Search">
  </div>
</form>
<br>


</div>
</body>
</html>
