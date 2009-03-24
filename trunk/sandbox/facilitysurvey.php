<?php
include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");
error_reporting(E_ALL);
ini_set ('display_errors', '1');

session_start();
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 //if( ($_SESSION['access_level_id'] != 7)){
 	//header( 'Location: ./index.php' );
 //} 

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Mike Ellerhorst
//
//  Spring 2009
//
// updatesou.php - enter a title here for the page
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

<div align="center">
  <h1>Update Facility Survey</h1>
</div>

<?php
$query = "SELECT	organization_name
		  FROM		organization
                  ORDER BY organization_name";
$result = mysql_query($query) or die ("Query Failed...could not retrieve organization information");
//$o_name= 'Sample Baptist Church';
//print $o_name;
?>
<form enctype="multipart/form-data" action="./facilitysurvey2.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
Choose a file to upload: <br>
<input name="uploadedfile" type="file" id = "uploadedfile"/><br />
<?php
       print "<select name=\"organization_name\" onchange=\"showResource(this.value)\">";
       print"<option value=\"NULL\"> </option>";
       while($row = mysql_fetch_assoc($result))
       {
            print"<option value=\"".$row['organization_name']."\">".$row['organization_name']."</option>";
       }
       print "</select>";
?>
<div>
<select name="filetype">
       <option value="NULL"> </option>
       <option value="txt">.txt</option>
       <option value="doc">.doc</option>
       <option value="pdf">.pdf</option>
</select>
</div>
<div>
<input type="submit" value="Send">
</div>
</form>

</body>
</html>