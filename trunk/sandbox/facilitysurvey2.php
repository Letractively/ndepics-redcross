<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
include ("config/dbconfig.php");
include ("config/opendb.php");

include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Facility Survey</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Mike Ellerhorst
//
//  Spring 2009
//
// blank.php - enter a title here for the page
//
// Revision History:  Created - 01/01/01
//
//****************************

$b = time ();
$d = date("Y-m-d", $b);
$result = $_POST["id"];

$datafile = $_FILES["uploadedfile"]["tmp_name"];

$fileName = $_FILES['uploadedfile']['name'];
$fileSize = $_FILES['uploadedfile']['size'];
$fileType = $_POST['filetype'];

$fp  = fopen($datafile, 'r');
$content = fread($fp, filesize($datafile));
$content = addslashes($content);
fclose($fp);
$query = "INSERT INTO facility_survey (organization_id, date_completed, uploaded_report,filename,filetype,filesize)
                VALUES (\"".$result."\", \"".$d."\", \"".$content."\", \"".$fileName."\",\"".$fileType."\",\"".$fileSize."\")";
$result2 = mysql_query($query) or die ("Query Failed...could not retrieve organization information2");

print "Facility survey successfully updated.";

include("html_include_3.php");
?>