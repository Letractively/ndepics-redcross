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
$expirationMonth = $_POST["expirationMonth"];
$expirationDay = $_POST["expirationDay"];
$expirationYear = $_POST["expirationYear"];

//Check file type and size parameters for security/integrity
if((($fileType == "application/pdf")
	 || ($fileType == "application/msword")
	 || ($fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
   && (fileSize < 2097152))
{
	if($_FILES["uploadedfile"]["error"] > 0) { //if uploaded file has an error
		print "File Error: ".$_FILES["uploadedfile"]["error"]."<br>"; //print the message
	} 
	else { //file is error-free, carry on with upload
      		
      		move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],"SOUs/" . $_FILES["uploadedfile"]["name"]);
      	
		
			//Overwrite
			$query = "UPDATE organization
						SET		statement_understanding = \"".$_FILES["uploadedfile"]["name"]."\"
						WHERE	organization_id = ".$org_id."
						LIMIT 	1";

			$result = mysql_query($query) or die ("Query Failed: Could not update file in database.");
			
		 
		
		// View SOU button
		if( !( ($_SESSION['access_level_id'] != 1) 
			&& ($_SESSION['access_level_id'] != 3) 
			&& ($_SESSION['access_level_id'] != 5) 
			&& ($_SESSION['access_level_id'] != 7) 
			& ($_SESSION['access_level_id'] != 9)))
		{

		echo"<a href=\"SOUs/".$_FILES["uploadedfile"]["name"]."\">View Statment of Understanding</a> <br />";
		
		}
	}
} else {
	print "Invalid File. <br /> Please ensure that you are choosing a correct file type and that the file is less than 2 MB. <br />";	
	print "<meta http-equiv='Refresh' content='3;url=./organizationinfo.php?id=".$org_id."' />";
} //end else

//Print file information
print"File Name: ".$_FILES["uploadedfile"]["name"]."<br>";
print"File Type: ".$_FILES["uploadedfile"]["type"]."<br>Size: ".$_FILES["uploadedfile"]["size"]."<br>";

print "<br />";

$expirationDate = $expirationYear."-".$expirationMonth."-".$expirationDay;
$today = getdate();

$expirationDateApproved = false;
if ( ($today["year"] < $expirationYear) || (($today["year"] == $expirationYear) && ($today["mon"] < $expirationMonth)) || 
		(($today["year"] == $expirationYear) && ($today["mon"] == $expirationMonth) && ($today["mday"] < $expirationDay)) ){
	$expirationDateApproved = true;
}

if($expirationDateApproved == true){
	//Overwrite
	$queryExpirationDate = "UPDATE organization 
								SET statement_expiration ='".$expirationDate."'
								WHERE organization_id = ".$org_id."
								LIMIT 	1";
	$resultExpirationDate = mysql_query($queryExpirationDate) or die ("Query Failed: Could not update expiration date in database.");
}
else{
	print "Invalid Date. <br /> Please ensure that the expiration date is after today's date. <br />";
	print "<meta http-equiv='Refresh' content='3;url=./organizationinfo.php?id=".$org_id."' />";
}
print "<button type='button' onClick=window.location='./organizationinfo.php?id=".$org_id."'>Back </button>";

include("./config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>