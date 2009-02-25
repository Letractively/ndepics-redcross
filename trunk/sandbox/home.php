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
// Revision History: 2/10/09	Mike Ellerhorst - Added "Create New User" button limited to admin users.
//												- Removed full url links for the iframe and menu bar
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

<div align="center">
  <h1>Welcome to the Disaster Database for the St. Joseph County Red Cross</h1>
</div>


<p align="center">Please select what you would like to do</p>

<?
if (($_SESSION['access_level_id']) == "9") { 

	print "<h2 align=\"center\">User Accounts</h2>\n";
	print "<div align=\"center\">\n";
	print "<table>\n";
	
	print   "<tr>\n";
	print	"<td>\n";
	print	"  <form action=\"./newuser.php\">\n";
	print	"  <input type=\"submit\" value=\"Create User\">\n";
	print	"  </form>\n";
	print	"</td>\n";
	
	print	"<td>\n";
	print	"  <form action=\"./modifyuser.php\">\n";
	print	"  <input type=\"submit\" value=\"Change User Access Level\">\n";
	print	"  </form>\n";
	print	"</td>\n";
	
	print	"<td>\n";
	print	"  <form action=\"./deleteuser.php\">\n";
	print	"  <input type=\"submit\" value=\"Delete User\">\n";
	print	"  </form>\n";
	print	"</td>\n";
	print	"</tr>\n";
	
	print "</table>\n";

	print "</div>\n";
}

//if the user can add information 
if( ($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))
{
print "<h2 align=\"center\">Input Information</h2>";

print "<div align=\"center\">";
print "<table>";
print "    <tr>";
print "    <td>";
print "	    <form action=\"addorganization.php\" >";
print "	    <input type=\"submit\" value=\"Add an organization\">";
print "	    </form>";
print "    </td>";
    
print "<td>";
print "	    <form action=\"addresource1.php\" >";
print "	    <input type=\"submit\" value=\"Add a Resource\">";
print "	    </form>";
print "    </td>";
   
print "<td>";
print "	    <form action=\"addperson.php\" >";
print "	    <input type=\"submit\" value=\"Add a Person\">";
print "	    </form>";
print "    </td>";
print "    </tr>";
print "  </table>";
print "  <center>";
print "</div>";
}

//if the user can search information
if( !($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0))
{
print "<h2 align=\"center\">Search Records</h2>";
print "<form action=\"search.php\" >";
print "  <div align=\"center\">";
print "    <input type=\"submit\" value=\"Search\">";
print "  </div>";
print "</form>";
print "<br>";
}
?>

</div>
</body>
</html>
