<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Spring 2009 - Alyssa Krauss and Chris Durr
// Summer 2010 - Matt Mooney
// sou.php - HTML and PHP to accept a file for upload
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
echo "<h1>Upload Statement of Understanding</h1><hr />";

//Pick up POSTed variable from updateorganization.php
$organization_id = $_POST["organization_id"];

//Get the organization name
$query = "SELECT	organization_name
          FROM		organization
          WHERE		organization_id = ".$organization_id;
$org = mysql_query($query) or die ("Query Failed...could not retrieve organization information");
$array = mysql_fetch_assoc($org);
$org = $array['organization_name'];

//print upload information and directions
print "Upload Statement of Understanding for " .$org.". Any existing file for this organization will be overwritten.";
print"<form enctype='multipart/form-data' action='./sou2.php' method='POST'>";
print"<input type='hidden' name='MAX_FILE_SIZE' value='2097152' >";
print"<input type=\"hidden\" name=\"id\" value=".$organization_id.">";
print"The maximum file size is 2MB<br />Most .pdf, .doc, and .docx files will be well under the limit.";
?>
Choose a file to upload:<br />
<input name="uploadedfile" type="file" id = "uploadedfile"/> <!-- Includes a browse button -->
<br />
Choose a File Type: <br />
<select name="extension">
       <option value="NULL"> </option>
       <option value="pdf">.pdf</option>
       <option value="doc">.doc</option>
       <option value="docx">.docx</option>
</select>
<div>
<input type="submit" value="Upload File">
</div>
</form>
<?
include("./config/closedb.php"); //close database connection
include("./html_include_3.php"); //close HTML tags
?>