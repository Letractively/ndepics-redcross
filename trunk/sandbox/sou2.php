<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Alyssa Krauss and Chris Durr
// Summer 2010 - Matt Mooney
// sou2.php - HTML and PHP to accept a file for upload
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - SoU Upload</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Pick up file infromation from uploaded file
$datafile = $_FILES["uploadedfile"]["tmp_name"];
$fileName = $_FILES["uploadedfile"]["name"];
$fileSize = $_FILES["uploadedfile"]["size"];
$fileType = $_FILES["uploadedfile"]["type"];

//Pick up POSTed variable from sou.php
$extension = $_POST["extension"];
$org_id    = $_POST["id"];

//Check file type and size parameters for security/integrity
if((($fileType == "application/pdf")
	 || ($fileType == "application/msword")
	 || ($fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
   && (fileSize < 2097152))
{
	if($_FILES["uploadedfile"]["error"] > 0) { //if uploaded file has an error
		print "File Error: ".$_FILES["uploadedfile"]["error"]."<br>"; //print the message
	} else { //file is error-free, carry on with upload
		//Set up Upload parameters
		//Upload BLOB to database
		$fp  = fopen($datafile, 'r');
		$content = fread($fp, filesize($datafile));
		$content = addslashes($content);
		fclose($fp);
		
		//Need check to see if file exists.
		$check_q = "SELECT *
					FROM statement_of_understanding 
					WHERE organization_id = '".$org_id." ' ";
		$check_r = mysql_query($check_q) or die ("Query Failed: Checking if file exists");
		$num_rows = mysql_num_rows($check_r);
		if ($num_rows != 0)
		{
			//Overwrite
			$query = "UPDATE statement_of_understanding
						SET		date_of_contract = NOW() ,
								uploaded_contract = \"".$content."\" ,
								filename = \"".$fileName."\" ,
								filetype = \"".$extension."\" ,
								filesize = \"".$fileSize."\"
						WHERE	organization_id = ".$org_id."
						LIMIT 	1";

			$result = mysql_query($query) or die ("Query Failed: Could not update file in database.");
		} else {
			//New Upload
			$query = "INSERT INTO statement_of_understanding
						(organization_id, 
						 date_of_contract, 
						 uploaded_contract, 
						 filename,
						 filetype,
						 filesize)
						VALUES 
						(\"".$org_id."\", 
						 NOW(), 
						 \"".$content."\", 
						 \"".$fileName."\",
						 \"".$extension."\",
						 \"".$fileSize."\")";
			$result2 = mysql_query($query) or die ("Query Failed: Could not save new file to database.");
		}
		// View SOU button
		if( !( ($_SESSION['access_level_id'] != 1) 
			&& ($_SESSION['access_level_id'] != 3) 
			&& ($_SESSION['access_level_id'] != 5) 
			&& ($_SESSION['access_level_id'] != 7) 
			& ($_SESSION['access_level_id'] != 9)))
		{
			print "<form action=\"./viewstatementofunderstanding.php\"  method=\"POST\">";
			print	"<input type=\"hidden\" name=\"organization_id\" value=".$org_id.">";
			print	"<input type=\"submit\" value=\"View Statement of Understanding\">";
			print "</form>";
		}
	}
} else {
	print "Invalid File.<br>Please ensure that you are choosing a correct file type and that the file is less than 2MB";	
} //end else

//Print file information
print"File Name: ".$_FILES["uploadedfile"]["name"]."<br>";
print"File Type: ".$_FILES["uploadedfile"]["type"]."<br>Size: ".$_FILES["uploadedfile"]["size"]."<br>";

include("./config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>