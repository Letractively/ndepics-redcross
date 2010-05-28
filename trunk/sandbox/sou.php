<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Spring 2009 - Alyssa Krauss and Chris Durr
// Summer 2010 - Matt Mooney
// sou.php - HTML and PHP to accept a file for upload
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");
include ("./html_include_1.php");
echo "<title>St. Joseph Red Cross - SoU Upload</title>";
include ("./html_include_2.php");
?>

<div align="center">
  <h2>Upload Statement of Understanding</h2><hr>
</div>

<?
$organization_id = $_POST["organization_id"];
$query = "SELECT	organization_name
          FROM		organization
          WHERE		organization_id = ".$organization_id;
$org = mysql_query($query) or die ("Query Failed...could not retrieve organization information");
$array = mysql_fetch_assoc($org);
$org = $array['organization_name'];
print "Upload Statement of Understanding for " .$org.". Any existing file for this organization will be overwritten.";

print"<form enctype='multipart/form-data' action='./sou2.php' method='POST'>";
print"<input type='hidden' name='MAX_FILE_SIZE' value='2097152' >";
print"<input type=\"hidden\" name=\"id\" value=".$organization_id.">";
print"The maximum file size is 2MB<br>Most .pdf, .doc, and .docx files will be well under the limit.";
?>

Choose a file to upload:<br>
<input name="uploadedfile" type="file" id = "uploadedfile"/>
<br>
Choose a File Type: <br>
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
include("./config/closedb.php");
include("./html_include_3.php"); 
?>