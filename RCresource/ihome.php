<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Update Information</title>";echo "<script src=\"./javascript/selectorganization.js\"></script>";include("html_include_2.php");
//****************************//  Developed by ND Epics for St. Joe County RedCross //  // Authors: Mike Ellerhorst & Mark Pasquier//  Fall 2008//// home.php - the main entry page for the Disaster Database;////****************************
?>
<div align="center">  <h1>Welcome to the Disaster Database for the St. Joseph County Red Cross</h1></div>
<center>
<p>Please select what you would like to do</p>
<h2>Input Information</h2>
</center>

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
</div>
</center>


<h2 align="center">Search Records</h2>
<form action="search.php" >
  <div align="center">
    <input type="submit" value="Search">
  </div>
</form>
<br>
<? include("html_include_3.php"); ?>