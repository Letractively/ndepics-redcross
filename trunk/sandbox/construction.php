<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Update Information</title>";echo "<script src=\"./javascript/selectorganization.js\"></script>";include("html_include_2.php");
?>
<center><h2> This page is currently under construction by the Notre Dame EPICS group.  If you have any questions or concerns regarding this page, please contact help@disaster.stjoe-redcross.org.  We apologize for any inconvenience this may cause.</h2></center><? include("html_include_3.php"); ?>