<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
  header( 'Location: ./index.php' );
 }

if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
  header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Matt Mooney & Alyssa Krauss
//  Fall 2009
//
// resourcetoperson.php - method to associate resource with a person
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("./config/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Resource-Person</title>

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
</head>
<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph\'s County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<?
 $person_id = $_POST['person_id'];


print "<h3 align='center'>Choose a resource to associate this person with</h3>";

    //This functionality is NOT here... merely a skeleton
//print "id is = ".$person_id;

 print "Select a Resource: ";
 
 $query = "Select * from detailed_resource ";
 $query .= "ORDER BY resource_type";
 
 $result = mysql_query($query) or die("Could not access resources");
 
 if( mysql_num_rows($result) < 1 )
   {
     print "There are no resources to be added, please go back and add a resource first!<br>";
   }
 else 
   {
     print "<form action='./resourcetoperson2.php' method='POST'>";
     print "<select name='resource_id' onchange='showResource(this.value)'>";
     print "<option value='NULL'> </option>";
     while( $row = mysql_fetch_assoc($result) )
       {
	 print "<option value='".$row['resource_id']."'>".$row['resource_type']."</option>";
       }
     print "</select>";
     print "<input type='hidden' name='person_id' value='".$person_id."'>";
     print "<input type='submit' value='Continue'>";
     print "</form>";
   }

include ("config/closedb.php");
?>

</body>
</html>
