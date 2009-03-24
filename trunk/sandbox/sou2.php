<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");
//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Alyssa Krauss and Chris Durr
//
//  Spring 2009
//
// sou2.php - enter a title here for the page
//
// Revision History:  Created - 01/01/01
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
  DIV.menu{ text-align: center; border-top:1px solid white; border-bottom:1px solid white; background-color:#000000; color:white; font-weight: bold}
  DIV.menu A:link { text-decoration: none; color:#FFFFFF; font-weight: bold }
  DIV.menu A:visited { text-decoration: none; color:#999999 }
  DIV.menu A:active { text-decoration: none; color:#666666 }
  DIV.menu A:hover { text-decoration: none; color:#FF0000 }
 </STYLE>


<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">
<div align="center" class="header">
<c>

<a href = "./home.php">
<img src="masthead.jpg" style="width:740px; height:100px" border="0"></a>
  			<p style="padding-bottom:1px; margin:0">
				American Red Cross, St. Joseph County Chapter
			</p>
			<p style="font-weight:normal; padding:0; margin: 0">
				<span>3220 East Jefferson Boulevard</span>
				<span>&nbsp;</span>
				<span>South Bend</span>
				<span>Indiana</span>
				<span>46615</span>
				<span>Phone (574) 234-0191</span>

			</p>
</c>
</div>
<div class="menu">
<a href = "./home.php"> HOME</a> | 
<a href = "./search.php"> SEARCH </a>
</div>

<?php
$b = time ();
$d = date("Y-m-d", $b);
$organization_name = $_POST["organization_name"];

$datafile = $_FILES["uploadedfile"]["tmp_name"];
$fileName = $_FILES['uploadedfile']['name'];
$fileSize = $_FILES['uploadedfile']['size'];
$fileType = $_POST['filetype'];

$fp  = fopen($datafile, 'r');
$content = fread($fp, filesize($datafile));
$content = addslashes($content);
fclose($fp);
$queryid = "SELECT organization_id FROM organization WHERE organization_name = '".$organization_name." ' ";
$result = mysql_query($queryid) or die ("Query Failed...could not retrieve organization information1");
$array = mysql_fetch_assoc($result);
$result = $array['organization_id'];
$query = "INSERT INTO statement_of_understanding (organization_id, date_of_contract, uploaded_contract, filename,filetype,filesize)
                VALUES (\"".$result."\", \"".$d."\", \"".$content."\", \"".$fileName."\",\"".$fileType."\",\"".$fileSize."\")";
$result2 = mysql_query($query) or die ("Query Failed...could not retrieve organization information2");
?>

<?php

		// sou BUTTON
		if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./viewstatementofunderstanding.php\"  method=\"POST\">";
		print			"<input type=\"hidden\" name=\"organization_id\" value=".$result.">";
		print			"<input type=\"submit\" value=\"View Statement of Understanding\">";
		print			"</form>";
		print		"</td>";
		}

?>

</body>
</html>