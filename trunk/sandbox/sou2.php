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
echo "<title>St. Joseph Red Cross</title>";
include("html_include_2.php");
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

$b = time ();
$d = date("Y-m-d", $b);
$result= $_POST["id"];

$datafile = $_FILES["uploadedfile"]["tmp_name"];
$fileName = $_FILES['uploadedfile']['name'];
$fileSize = $_FILES['uploadedfile']['size'];
$fileType = $_POST['filetype'];

$fp  = fopen($datafile, 'r');
$content = fread($fp, filesize($datafile));
$content = addslashes($content);
fclose($fp);
$query = "INSERT INTO statement_of_understanding (organization_id, date_of_contract, uploaded_contract, filename,filetype,filesize)
                VALUES (\"".$result."\", \"".$d."\", \"".$content."\", \"".$fileName."\",\"".$fileType."\",\"".$fileSize."\")";
$result2 = mysql_query($query) or die ("Query Failed...could not retrieve organization information2");

// sou BUTTON
if( !( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
{
	print		"<td><form action=\"./viewstatementofunderstanding.php\"  method=\"POST\">";
	print			"<input type=\"hidden\" name=\"organization_id\" value=".$result.">";
	print			"<input type=\"submit\" value=\"View Statement of Understanding\">";
	print			"</form>";
	print		"</td>";
}

include("html_include_3.php");
?>