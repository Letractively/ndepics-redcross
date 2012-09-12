<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Alyssa Krauss and Chris Durr
// Summer 2010 - Matt Mooney
// facilitysurvey2.php - HTML and PHP to accept a file for upload
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
include ("config/dbconfig.php");
include ("config/opendb.php");
include ("config/functions.php");
include ("html_include_1.php");
echo "<title>St. Joseph Red Cross - FS Upload</title>";
include ("html_include_2.php");

//Pick up file information from uploaded file
$datafile = $_FILES["uploadedfile"]["tmp_name"];
$fileName = $_FILES["uploadedfile"]["name"];
$fileSize = $_FILES["uploadedfile"]["size"];
$fileType = $_FILES["uploadedfile"]["type"];

//Pick up POSTed variables from facilitysurvey.php
$extension = $_POST["extension"];
$org_id    = $_POST["id"];

//Check file type and size parameters for security/integrity
if((($fileType == "application/pdf")
	 || ($fileType == "application/msword")
	 || ($fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
   && (fileSize < 2097152))
{
	if($_FILES["uploadedfile"]["error"] > 0) { //if there is a problem with the uploaded file
		print "File Error: ".$_FILES["uploadedfile"]["error"]."<br />"; //print the error
	} 
		else { //no problem with file, continue upload process

		    move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],"FSs/" . $_FILES["uploadedfile"]["name"]);
      	
		
			//Overwrite
			$query = "UPDATE organization
						SET		facility_survey = \"".$_FILES["uploadedfile"]["name"]."\"
						WHERE	organization_id = ".$org_id."
						LIMIT 	1";

			$result = mysql_query($query) or die ("Query Failed: Could not update file in database.");
			
		 


		// View FS button
		if( !( ($_SESSION['access_level_id'] != 1) 
			&& ($_SESSION['access_level_id'] != 3) 
			&& ($_SESSION['access_level_id'] != 5) 
			&& ($_SESSION['access_level_id'] != 7) 
			& ($_SESSION['access_level_id'] != 9)))
		{
		
			echo"<a href=\"FSs/".$_FILES["uploadedfile"]["name"]."\">View Facility Survey</a> <br />";

		}
	}
} else { //file is not valied
	print "Invalid File.<br />Please ensure that you are choosing a correct file type and that the file is less than 2MB";	
}// end else

//print information about the file.
print"File Name: ".$_FILES["uploadedfile"]["name"]."<br />";
print"File Type: ".$_FILES["uploadedfile"]["type"]."<br />Size: ".$_FILES["uploadedfile"]["size"]."<br />";

include("./config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>